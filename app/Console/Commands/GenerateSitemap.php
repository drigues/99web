<?php

namespace App\Console\Commands;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Gera o sitemap.xml e atualiza a cache';

    public function handle(): int
    {
        $sitemap = Sitemap::create();

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

        BlogCategory::select(['slug', 'updated_at'])->get()->each(function ($category) use ($sitemap) {
            $sitemap->add(
                Url::create(route('blog.category', $category->slug))
                    ->setLastModificationDate($category->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.7)
            );
        });

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

        // Atualiza a cache usada pelo SitemapController
        Cache::put('sitemap_xml', $sitemap->render(), 3600);

        $this->info('Sitemap gerado e cache atualizada.');

        return self::SUCCESS;
    }
}
