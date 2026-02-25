<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Services\SeoService;
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

        app(SeoService::class)
            ->setTitle('Blog — Dicas, novidades e tendências do mundo digital | 99web')
            ->setDescription('Descubra artigos sobre web design, SEO, marketing digital e tecnologia. Insights da equipa 99web para o sucesso do seu negócio online.')
            ->setKeywords('blog, web design, SEO, marketing digital, tecnologia, dicas, Portugal')
            ->setCanonical(route('blog.index'))
            ->setOgData(['title' => 'Blog 99web — Dicas e tendências do mundo digital'])
            ->addExtra('<link rel="alternate" type="application/rss+xml" title="Blog 99web RSS" href="' . route('blog.feed') . '">');

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

        $seo = app(SeoService::class)
            ->setTitle(($post->meta_title ?: $post->title) . ' | Blog 99web')
            ->setDescription($post->meta_description ?: $post->excerpt)
            ->setCanonical($post->canonical_url ?? route('blog.show', $post->slug))
            ->setOgData([
                'type'        => 'article',
                'title'       => $post->meta_title ?: $post->title,
                'description' => $post->meta_description ?: $post->excerpt,
                'image'       => $post->og_image ?? $post->featured_image ?? asset('images/og-default.png'),
            ])
            ->setArticleSchema($post)
            ->setBreadcrumbSchema([
                ['name' => 'Home',  'url' => route('home')],
                ['name' => 'Blog',  'url' => route('blog.index')],
                ['name' => $post->category->name ?? 'Artigos', 'url' => $post->category ? route('blog.category', $post->category->slug) : route('blog.index')],
                ['name' => $post->title],
            ]);

        if ($post->meta_keywords) {
            $seo->setKeywords($post->meta_keywords);
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

        app(SeoService::class)
            ->setTitle(($category->meta_title ?: $category->name . ' — Blog') . ' | 99web')
            ->setDescription($category->meta_description ?: 'Artigos sobre ' . $category->name . ' — dicas e insights da equipa 99web.')
            ->setCanonical(route('blog.category', $category->slug))
            ->setOgData([
                'title'       => $category->name . ' — Blog 99web',
                'description' => $category->meta_description ?: 'Descubra artigos sobre ' . $category->name . ' no blog da 99web.',
            ])
            ->setBreadcrumbSchema([
                ['name' => 'Home',         'url' => route('home')],
                ['name' => 'Blog',         'url' => route('blog.index')],
                ['name' => $category->name],
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

        app(SeoService::class)
            ->setTitle('#' . $tag->name . ' — Blog | 99web')
            ->setDescription('Artigos com a tag ' . $tag->name . ' — dicas e insights da equipa 99web.')
            ->setCanonical(route('blog.tag', $tag->slug))
            ->setOgData([
                'title'       => '#' . $tag->name . ' — Blog 99web',
                'description' => 'Descubra artigos sobre ' . $tag->name . ' no blog da 99web.',
            ])
            ->setBreadcrumbSchema([
                ['name' => 'Home',            'url' => route('home')],
                ['name' => 'Blog',            'url' => route('blog.index')],
                ['name' => '#' . $tag->name],
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
