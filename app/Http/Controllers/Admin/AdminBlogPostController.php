<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogPostRequest;
use App\Http\Requests\Admin\UpdateBlogPostRequest;
use App\Models\AdminUser;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\Laravel\Facades\Image;

class AdminBlogPostController extends Controller
{
    private const PER_PAGE = 15;

    public function index(Request $request): View
    {
        $query = BlogPost::with(['category', 'author'])
            ->latest('updated_at');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            match ($status) {
                'publicado' => $query->where('is_published', true)->where('published_at', '<=', now()),
                'agendado'  => $query->where('is_published', true)->where('published_at', '>', now()),
                'rascunho'  => $query->where('is_published', false),
                default     => null,
            };
        }

        if ($categorySlug = $request->input('categoria')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
        }

        $posts      = $query->paginate(self::PER_PAGE)->withQueryString();
        $categories = BlogCategory::ordered()->get();

        return view('admin.blog.index', compact('posts', 'categories'));
    }

    public function create(): View
    {
        $categories = BlogCategory::ordered()->get();
        $tags       = BlogTag::orderBy('name')->get();
        $authors    = AdminUser::orderBy('name')->get();
        $post       = null;

        return view('admin.blog.create', compact('categories', 'tags', 'authors', 'post'));
    }

    public function store(StoreBlogPostRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['is_published'] = (bool) ($data['is_published'] ?? false);

        if ($data['is_published'] && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $post = BlogPost::create(array_except_keys($data, ['tags']));

        if (!empty($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return redirect()
            ->route('admin.blog.edit', $post)
            ->with('success', 'Artigo criado com sucesso.');
    }

    public function edit(BlogPost $post): View
    {
        $post->load(['category', 'author', 'tags']);
        $categories = BlogCategory::ordered()->get();
        $tags       = BlogTag::orderBy('name')->get();
        $authors    = AdminUser::orderBy('name')->get();

        return view('admin.blog.edit', compact('post', 'categories', 'tags', 'authors'));
    }

    public function update(UpdateBlogPostRequest $request, BlogPost $post): RedirectResponse
    {
        $data = $request->validated();

        $data['is_published'] = (bool) ($data['is_published'] ?? false);

        if ($data['is_published'] && empty($data['published_at'])) {
            if (!$post->is_published) {
                $data['published_at'] = now();
            }
        }

        if (!$data['is_published']) {
            $data['published_at'] = $post->published_at;
        }

        $post->update(array_except_keys($data, ['tags']));
        $post->tags()->sync($data['tags'] ?? []);

        return redirect()
            ->route('admin.blog.edit', $post)
            ->with('success', 'Artigo atualizado com sucesso.');
    }

    public function destroy(BlogPost $post): RedirectResponse
    {
        if ($post->featured_image && str_starts_with($post->featured_image, '/storage/')) {
            $storagePath = str_replace('/storage/', '', $post->featured_image);
            Storage::disk('public')->delete($storagePath);
        }

        if ($post->og_image && str_starts_with($post->og_image, '/storage/')) {
            $storagePath = str_replace('/storage/', '', $post->og_image);
            Storage::disk('public')->delete($storagePath);
        }

        $post->delete();

        return redirect()
            ->route('admin.blog.index')
            ->with('success', 'Artigo eliminado com sucesso.');
    }

    public function togglePublish(BlogPost $post): JsonResponse
    {
        $post->is_published = !$post->is_published;

        if ($post->is_published && !$post->published_at) {
            $post->published_at = now();
        }

        $post->save();

        return response()->json([
            'ok'           => true,
            'is_published' => $post->is_published,
            'published_at' => $post->published_at?->toIso8601String(),
        ]);
    }

    public function duplicate(BlogPost $post): RedirectResponse
    {
        $duplicate = $post->replicate();
        $duplicate->title        = $post->title . ' (cópia)';
        $duplicate->slug         = $post->slug . '-copia-' . Str::random(4);
        $duplicate->is_published = false;
        $duplicate->published_at = null;
        $duplicate->views_count  = 0;
        $duplicate->save();

        $duplicate->tags()->sync($post->tags()->pluck('blog_tags.id'));

        return redirect()
            ->route('admin.blog.edit', $duplicate)
            ->with('success', 'Artigo duplicado. Edite e publique quando estiver pronto.');
    }

    public function bulk(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => ['required', 'in:publicar,despublicar,eliminar'],
            'ids'    => ['required', 'array'],
            'ids.*'  => ['exists:blog_posts,id'],
        ]);

        $posts = BlogPost::whereIn('id', $request->input('ids'))->get();

        match ($request->input('action')) {
            'publicar' => $posts->each(function ($p) {
                $p->is_published = true;
                if (!$p->published_at) {
                    $p->published_at = now();
                }
                $p->save();
            }),
            'despublicar' => BlogPost::whereIn('id', $request->input('ids'))
                ->update(['is_published' => false]),
            'eliminar' => BlogPost::whereIn('id', $request->input('ids'))->delete(),
        };

        $count  = count($request->input('ids'));
        $labels = ['publicar' => 'publicados', 'despublicar' => 'despublicados', 'eliminar' => 'eliminados'];

        return redirect()
            ->route('admin.blog.index')
            ->with('success', "{$count} artigo(s) {$labels[$request->input('action')]} com sucesso.");
    }

    public function preview(BlogPost $post): View
    {
        $post->load(['category', 'author', 'tags']);

        return view('admin.blog.preview', compact('post'));
    }

    public function uploadImage(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ]);

        $filename = 'blog_' . uniqid() . '.webp';
        $dir      = storage_path('app/public/blog');

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        Image::read($request->file('file'))
            ->scaleDown(width: 1200)
            ->toWebp(quality: 85)
            ->save($dir . '/' . $filename);

        return response()->json([
            'location' => Storage::disk('public')->url('blog/' . $filename),
        ]);
    }
}

// ── Helper (array without specific keys) ────────────────────────
if (!function_exists('array_except_keys')) {
    function array_except_keys(array $array, array $keys): array
    {
        return array_diff_key($array, array_flip($keys));
    }
}
