<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogCategoryRequest;
use App\Models\BlogCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminBlogCategoryController extends Controller
{
    public function index(): View
    {
        $categories = BlogCategory::ordered()
            ->withCount('posts')
            ->get();

        return view('admin.blog.categorias.index', compact('categories'));
    }

    public function store(StoreBlogCategoryRequest $request): JsonResponse
    {
        $data         = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        // Ensure unique slug
        $base = $data['slug'];
        $i    = 1;
        while (BlogCategory::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $base . '-' . $i++;
        }

        $category = BlogCategory::create($data);
        $category->loadCount('posts');

        return response()->json([
            'ok'       => true,
            'category' => $category,
        ], 201);
    }

    public function update(StoreBlogCategoryRequest $request, BlogCategory $category): JsonResponse
    {
        $data = $request->validated();

        // Only regenerate slug if name changed
        if ($data['name'] !== $category->name) {
            $base = Str::slug($data['name']);
            $slug = $base;
            $i    = 1;
            while (BlogCategory::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = $base . '-' . $i++;
            }
            $data['slug'] = $slug;
        }

        $category->update($data);
        $category->loadCount('posts');

        return response()->json([
            'ok'       => true,
            'category' => $category->fresh(),
        ]);
    }

    public function destroy(BlogCategory $category): JsonResponse
    {
        $postsCount = $category->posts()->count();

        if ($postsCount > 0) {
            return response()->json([
                'ok'    => false,
                'error' => "Não é possível eliminar: esta categoria tem {$postsCount} artigo(s) associado(s).",
            ], 422);
        }

        $category->delete();

        return response()->json(['ok' => true]);
    }

    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'items'         => ['required', 'array'],
            'items.*.id'    => ['required', 'exists:blog_categories,id'],
            'items.*.order' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($request->input('items') as $item) {
            BlogCategory::where('id', $item['id'])->update(['sort_order' => $item['order']]);
        }

        return response()->json(['ok' => true]);
    }
}
