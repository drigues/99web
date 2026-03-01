<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

        // ─── SEO ─────────────────────────────────────────────
        SEOMeta::setTitle('Blog — Dicas, novidades e tendências do mundo digital');
        SEOMeta::setDescription('Descubra artigos sobre web design, SEO, marketing digital e tecnologia. Insights da equipa 99web para o sucesso do seu negócio online.');
        SEOMeta::setKeywords(['blog', 'web design', 'SEO', 'marketing digital', 'tecnologia', 'dicas', 'Portugal']);
        SEOMeta::setCanonical(route('blog.index'));

        OpenGraph::setTitle('Blog 99web — Dicas e tendências do mundo digital');
        OpenGraph::setDescription('Descubra artigos sobre web design, SEO, marketing digital e tecnologia.');
        OpenGraph::setUrl(route('blog.index'));
        OpenGraph::addImage(asset('images/og-default.png'));

        TwitterCard::setTitle('Blog 99web');
        TwitterCard::setDescription('Descubra artigos sobre web design, SEO, marketing digital e tecnologia.');

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

        // ─── SEO ─────────────────────────────────────────────
        $metaTitle = ($post->meta_title ?: $post->title) . ' | Blog 99web';
        $metaDesc  = $post->meta_description ?: $post->excerpt;
        $ogImage   = $post->og_image ?? $post->featured_image ?? asset('images/og-default.png');

        SEOMeta::setTitle($metaTitle);
        SEOMeta::setDescription($metaDesc);
        SEOMeta::setCanonical($post->canonical_url ?? route('blog.show', $post->slug));
        if ($post->meta_keywords) {
            SEOMeta::setKeywords(explode(',', $post->meta_keywords));
        }

        OpenGraph::setTitle($post->meta_title ?: $post->title);
        OpenGraph::setDescription($metaDesc);
        OpenGraph::setUrl(route('blog.show', $post->slug));
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'pt_PT');
        OpenGraph::addImage($ogImage);
        OpenGraph::addProperty('article:published_time', optional($post->published_at)->toIso8601String());
        OpenGraph::addProperty('article:modified_time', optional($post->updated_at)->toIso8601String());
        if ($post->category) {
            OpenGraph::addProperty('article:section', $post->category->name);
        }

        TwitterCard::setTitle($post->meta_title ?: $post->title);
        TwitterCard::setDescription($metaDesc);
        TwitterCard::setImage($ogImage);

        // ─── JSON-LD: Article + Breadcrumb ──────────────────
        $content = strip_tags($post->content ?? '');

        JsonLd::setType('BlogPosting');
        JsonLd::setTitle($post->title);
        JsonLd::setDescription($post->excerpt ?? '');
        JsonLd::setUrl(route('blog.show', $post->slug));
        JsonLd::addValue('headline', $post->title);
        JsonLd::addValue('wordCount', str_word_count($content));
        JsonLd::addValue('datePublished', optional($post->published_at)->toIso8601String());
        JsonLd::addValue('dateModified', optional($post->updated_at)->toIso8601String());
        JsonLd::addValue('author', [
            '@type' => 'Person',
            'name'  => $post->author->name ?? '99web',
        ]);
        JsonLd::addValue('publisher', [
            '@type' => 'Organization',
            'name'  => '99web',
            'logo'  => ['@type' => 'ImageObject', 'url' => asset('images/logo.png')],
        ]);
        if ($post->category) {
            JsonLd::addValue('articleSection', $post->category->name);
        }
        if ($ogImage) {
            JsonLd::addImage($ogImage);
        }

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

        // ─── SEO ─────────────────────────────────────────────
        $metaTitle = ($category->meta_title ?: $category->name . ' — Blog') . ' | 99web';
        $metaDesc  = $category->meta_description ?: 'Artigos sobre ' . $category->name . ' — dicas e insights da equipa 99web.';

        SEOMeta::setTitle($metaTitle);
        SEOMeta::setDescription($metaDesc);
        SEOMeta::setCanonical(route('blog.category', $category->slug));

        OpenGraph::setTitle($category->name . ' — Blog 99web');
        OpenGraph::setDescription($metaDesc);
        OpenGraph::setUrl(route('blog.category', $category->slug));
        OpenGraph::addImage(asset('images/og-default.png'));

        TwitterCard::setTitle($category->name . ' — Blog 99web');
        TwitterCard::setDescription($metaDesc);

        // Breadcrumb JSON-LD
        JsonLd::setType('BreadcrumbList');
        JsonLd::addValue('itemListElement', [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => route('blog.index')],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $category->name],
        ]);

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

        // ─── SEO ─────────────────────────────────────────────
        SEOMeta::setTitle('#' . $tag->name . ' — Blog | 99web');
        SEOMeta::setDescription('Artigos com a tag ' . $tag->name . ' — dicas e insights da equipa 99web.');
        SEOMeta::setCanonical(route('blog.tag', $tag->slug));

        OpenGraph::setTitle('#' . $tag->name . ' — Blog 99web');
        OpenGraph::setDescription('Descubra artigos sobre ' . $tag->name . ' no blog da 99web.');
        OpenGraph::setUrl(route('blog.tag', $tag->slug));
        OpenGraph::addImage(asset('images/og-default.png'));

        TwitterCard::setTitle('#' . $tag->name . ' — Blog 99web');
        TwitterCard::setDescription('Descubra artigos sobre ' . $tag->name . ' no blog da 99web.');

        // Breadcrumb JSON-LD
        JsonLd::setType('BreadcrumbList');
        JsonLd::addValue('itemListElement', [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => route('blog.index')],
            ['@type' => 'ListItem', 'position' => 3, 'name' => '#' . $tag->name],
        ]);

        return view('blog.tag', compact('tag', 'posts', 'categories', 'tags'));
    }

    public function feed(): Response
    {
        $posts = BlogPost::published()
            ->with(['category', 'author'])
            ->latest('published_at')
            ->limit(20)
            ->get();

        $xml = view('blog.feed', compact('posts'))->render();

        return response($xml, 200, [
            'Content-Type' => 'application/rss+xml; charset=UTF-8',
        ]);
    }

    // ── Private helpers ────────────────────────────────────────

    private function sidebarData(): array
    {
        $categories = BlogCategory::ordered()
            ->withCount(['posts' => fn ($q) => $q->published()])
            ->get();

        $tags = BlogTag::withCount(['posts' => fn ($q) => $q->published()])
            ->get()
            ->filter(fn ($tag) => $tag->posts_count > 0)
            ->sortByDesc('posts_count')
            ->take(30);

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
