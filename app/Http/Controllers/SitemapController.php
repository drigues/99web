<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $xml = Cache::remember('sitemap_xml', 3600, function () {
            $sitemap = Sitemap::create();

            // ── Páginas estáticas ──
            $sitemap->add(
                Url::create(route('home'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(1.0)
            );

            $sitemap->add(
                Url::create(route('blog.index'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.9)
            );

            foreach (['essencial', 'corporativo', 'personalizado'] as $type) {
                $sitemap->add(
                    Url::create(route('pacotes.show', $type))
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                        ->setPriority(0.8)
                );
            }

            // ── Categorias do blog ──
            BlogCategory::select(['slug', 'updated_at'])->get()->each(function ($category) use ($sitemap) {
                $sitemap->add(
                    Url::create(route('blog.category', $category->slug))
                        ->setLastModificationDate($category->updated_at)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setPriority(0.7)
                );
            });

            // ── Artigos do blog ──
            BlogPost::published()
                ->select(['slug', 'updated_at', 'published_at', 'is_published'])
                ->latest('published_at')
                ->get()
                ->each(function ($post) use ($sitemap) {
                    $sitemap->add(
                        Url::create(route('blog.show', $post->slug))
                            ->setLastModificationDate($post->updated_at)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                            ->setPriority(0.6)
                    );
                });

            return $sitemap->render();
        });

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    public function robots(): Response
    {
        $content  = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin\n";
        $content .= "Disallow: /livewire\n";
        $content .= "\n";
        $content .= "Sitemap: https://99web.pt/sitemap.xml\n";

        return response($content, 200, ['Content-Type' => 'text/plain']);
    }
}
