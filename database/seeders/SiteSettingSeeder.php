<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name',    'value' => '99web',                    'type' => 'text',     'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Agência Digital · Portugal','type' => 'text',    'group' => 'general'],

            // Contact
            ['key' => 'email',        'value' => 'geral@99web.pt',           'type' => 'text',     'group' => 'contact'],
            ['key' => 'phone',        'value' => '+351 210 000 000',         'type' => 'text',     'group' => 'contact'],
            ['key' => 'address',      'value' => 'Av. da Liberdade, 110, 1250-096 Lisboa', 'type' => 'text', 'group' => 'contact'],

            // Social
            ['key' => 'social_links', 'value' => json_encode([
                'instagram' => 'https://instagram.com/99web',
                'linkedin'  => 'https://linkedin.com/company/99web',
                'facebook'  => 'https://facebook.com/99web',
            ]), 'type' => 'json', 'group' => 'social'],

            // SEO
            ['key' => 'meta_description', 'value' => 'Criamos a sua presença online — seja encontrado pelos seus públicos com um site que converte.', 'type' => 'textarea', 'group' => 'seo'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
