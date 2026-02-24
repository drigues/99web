<?php

return [

    'essencial' => [
        'slug'        => 'essencial',
        'name'        => 'Web Essencial',
        'badge'       => 'Starter',
        'price'       => '399€',
        'price_note'  => 'pagamento único',
        'description' => 'Ideal para pequenos negócios que precisam de uma presença online profissional e rápida.',
        'highlight'   => false,
        'features'    => [
            'Design profissional e responsivo',
            'Até 5 páginas',
            'Formulário de contacto',
            'SEO básico',
            'Entrega em 7–14 dias',
            'Alojamento e domínio incluído (1 ano)',
        ],
    ],

    'corporativo' => [
        'slug'        => 'corporativo',
        'name'        => 'Web Corporativo',
        'badge'       => 'Mais Popular',
        'price'       => '599€',
        'price_note'  => 'pagamento único',
        'description' => 'Para empresas que querem presença digital completa, com SEO avançado e blog integrado.',
        'highlight'   => true,
        'features'    => [
            'Design profissional e responsivo',
            'Até 10 páginas',
            'Formulário de contacto',
            'SEO básico + avançado',
            'Integração com redes sociais',
            'Google Maps + Analytics',
            'Blog integrado',
            'Suporte prioritário 30 dias',
        ],
    ],

    'personalizado' => [
        'slug'        => 'personalizado',
        'name'        => 'Projetos Personalizados',
        'badge'       => 'Custom',
        'price'       => 'Sob consulta',
        'price_note'  => 'proposta à medida do projeto',
        'description' => 'Soluções à medida para projetos complexos: e-commerce, sistemas, integrações, dashboards.',
        'highlight'   => false,
        'features'    => [
            'Sistemas web à medida',
            'E-commerce e lojas digitais',
            'Integrações com APIs',
            'Dashboards e painéis admin',
            'Manutenção e suporte contínuo',
        ],
    ],

];
