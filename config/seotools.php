<?php

return [
    'inertia' => false,

    'meta' => [
        'defaults' => [
            'title'       => '99web',
            'titleBefore' => false,
            'description' => 'Criamos websites profissionais, sistemas web e estratégias SEO que impulsionam o crescimento do seu negócio. Especialistas em soluções digitais em Portugal.',
            'separator'   => ' — ',
            'keywords'    => ['agência digital', 'websites profissionais', 'desenvolvimento web', 'SEO', 'marketing digital', 'Portugal', '99web'],
            'canonical'   => 'current',
            'robots'      => 'index, follow',
        ],
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],
        'add_notranslate_class' => false,
    ],

    'opengraph' => [
        'defaults' => [
            'title'       => '99web — Agência Digital',
            'description' => 'Criamos websites profissionais, sistemas web e estratégias SEO que impulsionam o crescimento do seu negócio.',
            'url'         => null,
            'type'        => 'website',
            'site_name'   => '99web',
            'images'      => [],
        ],
    ],

    'twitter' => [
        'defaults' => [
            'card' => 'summary_large_image',
        ],
    ],

    'json-ld' => [
        'defaults' => [
            'title'       => '99web',
            'description' => 'Agência digital especializada em desenvolvimento web, SEO e marketing digital em Portugal.',
            'url'         => 'current',
            'type'        => 'WebPage',
            'images'      => [],
        ],
    ],
];
