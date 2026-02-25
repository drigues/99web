<?php

namespace App\Services;

class SeoService
{
    private string $title       = '';
    private string $description = '';
    private string $keywords    = '';
    private string $canonical   = '';
    private string $robots      = 'index, follow';
    private array  $og          = [];
    private array  $twitter     = [];
    private array  $schemas     = [];
    private array  $extras      = [];

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription(string $desc): static
    {
        $this->description = $desc;
        return $this;
    }

    public function setKeywords(string $keywords): static
    {
        $this->keywords = $keywords;
        return $this;
    }

    public function setCanonical(string $url): static
    {
        $this->canonical = $url;
        return $this;
    }

    public function setRobots(string $robots): static
    {
        $this->robots = $robots;
        return $this;
    }

    public function setOgData(array $data): static
    {
        $this->og = array_merge($this->og, $data);
        return $this;
    }

    public function setTwitterCard(array $data): static
    {
        $this->twitter = array_merge($this->twitter, $data);
        return $this;
    }

    public function addExtra(string $html): static
    {
        $this->extras[] = $html;
        return $this;
    }

    public function setArticleSchema(object $post): static
    {
        $content = strip_tags($post->content ?? '');

        $schema = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BlogPosting',
            'headline'        => $post->title,
            'description'     => $post->excerpt ?? '',
            'wordCount'       => str_word_count($content),
            'datePublished'   => optional($post->published_at)->toIso8601String(),
            'dateModified'    => optional($post->updated_at)->toIso8601String(),
            'url'             => route('blog.show', $post->slug),
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id'   => route('blog.show', $post->slug),
            ],
            'author' => [
                '@type' => 'Person',
                'name'  => $post->author->name ?? '99web',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name'  => '99web',
                'logo'  => [
                    '@type' => 'ImageObject',
                    'url'   => asset('images/logo.png'),
                ],
            ],
        ];

        if ($post->category ?? null) {
            $schema['articleSection'] = $post->category->name;
        }

        $image = $post->og_image ?? $post->featured_image ?? null;
        if ($image) {
            $schema['image'] = ['@type' => 'ImageObject', 'url' => $image];
        }

        $this->schemas[] = $schema;
        return $this;
    }

    public function setBreadcrumbSchema(array $items): static
    {
        $listItems = [];

        foreach ($items as $i => $item) {
            $listItem = [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => $item['name'],
            ];

            if (isset($item['url'])) {
                $listItem['item'] = $item['url'];
            }

            $listItems[] = $listItem;
        }

        $this->schemas[] = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $listItems,
        ];

        return $this;
    }

    public function setOrganizationSchema(): static
    {
        $this->schemas[] = [
            '@context' => 'https://schema.org',
            '@type'    => 'Organization',
            'name'     => '99web',
            'url'      => config('app.url'),
            'logo'     => asset('images/logo.png'),
            'contactPoint' => [
                '@type'             => 'ContactPoint',
                'contactType'       => 'customer service',
                'availableLanguage' => 'Portuguese',
            ],
        ];

        return $this;
    }

    public function setLocalBusinessSchema(): static
    {
        $this->schemas[] = [
            '@context'           => 'https://schema.org',
            '@type'              => 'ProfessionalService',
            'name'               => '99web',
            'description'        => 'Agência digital especializada em desenvolvimento web, SEO e marketing digital.',
            'url'                => config('app.url'),
            'priceRange'         => '€€',
            'currenciesAccepted' => 'EUR',
            'paymentAccepted'    => 'Credit Card, Bank Transfer',
            'areaServed'         => 'Portugal',
            'availableLanguage'  => ['Portuguese', 'English'],
        ];

        return $this;
    }

    public function toHtml(): string
    {
        $lines = [];

        // Title
        $title    = $this->title ?: config('app.name', '99web');
        $lines[]  = '<title>' . e($title) . '</title>';

        // Description
        if ($this->description) {
            $lines[] = '<meta name="description" content="' . e($this->description) . '">';
        }

        // Keywords
        if ($this->keywords) {
            $lines[] = '<meta name="keywords" content="' . e($this->keywords) . '">';
        }

        // Robots + Author
        $lines[] = '<meta name="robots" content="' . e($this->robots) . '">';
        $lines[] = '<meta name="author" content="99web">';

        // Canonical
        $canonical = $this->canonical ?: url()->current();
        $lines[]   = '<link rel="canonical" href="' . e($canonical) . '">';

        // Open Graph
        $og = array_merge([
            'type'        => 'website',
            'url'         => $canonical,
            'title'       => $title,
            'description' => $this->description,
            'image'       => asset('images/og-default.png'),
            'locale'      => 'pt_PT',
            'site_name'   => '99web',
        ], $this->og);

        foreach ($og as $key => $value) {
            if ($value !== '' && $value !== null) {
                $lines[] = '<meta property="og:' . $key . '" content="' . e($value) . '">';
            }
        }

        // Twitter Card
        $twitter = array_merge([
            'card'        => 'summary_large_image',
            'title'       => $title,
            'description' => $this->description,
            'image'       => asset('images/og-default.png'),
        ], $this->twitter);

        foreach ($twitter as $key => $value) {
            if ($value !== '' && $value !== null) {
                $lines[] = '<meta name="twitter:' . $key . '" content="' . e($value) . '">';
            }
        }

        // JSON-LD Schemas
        foreach ($this->schemas as $schema) {
            $json    = json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            $lines[] = '<script type="application/ld+json">' . $json . '</script>';
        }

        // Extras (RSS link, etc.)
        foreach ($this->extras as $extra) {
            $lines[] = $extra;
        }

        return implode("\n    ", $lines);
    }
}
