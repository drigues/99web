<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogController extends Controller
{
    private const PER_PAGE = 12;

    public function index(Request $request): View
    {
        $query = BlogPost::published()
            ->with(['category', 'author', 'tags'])
            ->latest('published_at');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        if ($categorySlug = $request->input('categoria')) {
            $query->byCategory($categorySlug);
        }

        if ($tagSlug = $request->input('tag')) {
            $query->byTag($tagSlug);
        }

        $posts = $query->paginate(self::PER_PAGE)->withQueryString();

        [$categories, $tags] = $this->sidebarData();

        $hasFilters = $request->hasAny(['search', 'categoria', 'tag']);

        $activeCategorySlug = $request->input('categoria');
        $activeTagSlug      = $request->input('tag');

        $featuredPost   = null;
        $remainingPosts = $posts;

        if (!$hasFilters && $posts->currentPage() === 1 && $posts->isNotEmpty()) {
            $featuredPost   = $posts->first();
            $remainingPosts = $posts->slice(1);
        }

        return view('blog.index', compact(
            'posts', 'featuredPost', 'remainingPosts',
            'categories', 'tags',
            'activeCategorySlug', 'activeTagSlug', 'hasFilters'
        ));
    }

    public function show(string $slug): View
    {
        $post = BlogPost::published()
            ->with(['category', 'author', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        $post->incrementViews();

        $toc            = $this->extractToc($post->content);
        $contentWithIds = $this->addHeadingIds($post->content);

        $relatedPosts = BlogPost::published()
            ->with(['category', 'author'])
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('blog.show', compact('post', 'toc', 'contentWithIds', 'relatedPosts'));
    }

    public function category(string $slug): View
    {
        $category = BlogCategory::where('slug', $slug)->firstOrFail();

        $posts = BlogPost::published()
            ->with(['category', 'author', 'tags'])
            ->where('category_id', $category->id)
            ->latest('published_at')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        [$categories, $tags] = $this->sidebarData();

        return view('blog.category', compact('category', 'posts', 'categories', 'tags'));
    }

    public function tag(string $slug): View
    {
        $tag = BlogTag::where('slug', $slug)->firstOrFail();

        $posts = BlogPost::published()
            ->with(['category', 'author', 'tags'])
            ->byTag($slug)
            ->latest('published_at')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        [$categories, $tags] = $this->sidebarData();

        return view('blog.tag', compact('tag', 'posts', 'categories', 'tags'));
    }

    // ── Private helpers ────────────────────────────────────────

    private function sidebarData(): array
    {
        $categories = BlogCategory::ordered()
            ->withCount(['posts' => fn ($q) => $q->published()])
            ->get();

        $tags = BlogTag::withCount(['posts' => fn ($q) => $q->published()])
            ->having('posts_count', '>', 0)
            ->orderByDesc('posts_count')
            ->limit(30)
            ->get();

        return [$categories, $tags];
    }

    private function extractToc(string $html): array
    {
        preg_match_all('/<(h[23])[^>]*>(.*?)<\/h[23]>/is', $html, $matches, PREG_SET_ORDER);

        $toc = [];
        $ids = [];

        foreach ($matches as $match) {
            $text   = strip_tags($match[2]);
            $baseId = Str::slug($text);
            $id     = $baseId;
            $n      = 1;

            while (in_array($id, $ids)) {
                $id = $baseId . '-' . $n++;
            }

            $ids[]  = $id;
            $toc[]  = ['level' => $match[1], 'text' => $text, 'id' => $id];
        }

        return $toc;
    }

    private function addHeadingIds(string $html): string
    {
        $ids = [];

        return preg_replace_callback(
            '/<(h[23])([^>]*)>(.*?)<\/h[23]>/is',
            function ($m) use (&$ids) {
                if (str_contains($m[2], 'id=')) {
                    return $m[0];
                }

                $text   = strip_tags($m[3]);
                $baseId = Str::slug($text);
                $id     = $baseId;
                $n      = 1;

                while (in_array($id, $ids)) {
                    $id = $baseId . '-' . $n++;
                }

                $ids[] = $id;

                return "<{$m[1]}{$m[2]} id=\"{$id}\">{$m[3]}</{$m[1]}>";
            },
            $html
        );
    }
}
