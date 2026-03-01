<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // === GERAL ===
            ['key' => 'site_name', 'value' => '99web', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Criamos websites modernos, sistemas corporativos e presença digital premium para empresas portuguesas.', 'type' => 'textarea', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'geral@99web.pt', 'type' => 'text', 'group' => 'general'],
            ['key' => 'contact_phone', 'value' => '+351 912 345 678', 'type' => 'text', 'group' => 'general'],
            ['key' => 'contact_address', 'value' => 'Caldas da Rainha, Portugal', 'type' => 'textarea', 'group' => 'general'],
            ['key' => 'working_hours', 'value' => 'Seg-Sex 9h-18h', 'type' => 'text', 'group' => 'general'],
            ['key' => 'whatsapp_number', 'value' => '+351912345678', 'type' => 'text', 'group' => 'general'],
            ['key' => 'copyright_text', 'value' => '© 2025 99web. Todos os direitos reservados.', 'type' => 'text', 'group' => 'general'],
            ['key' => 'footer_tagline', 'value' => 'Agência digital especializada em websites, sistemas corporativos e visibilidade no Google.', 'type' => 'textarea', 'group' => 'general'],

            // === REDES SOCIAIS ===
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/99web.pt', 'type' => 'text', 'group' => 'social'],
            ['key' => 'social_linkedin', 'value' => 'https://linkedin.com/company/99web', 'type' => 'text', 'group' => 'social'],
            ['key' => 'social_github', 'value' => 'https://github.com/99web', 'type' => 'text', 'group' => 'social'],
            ['key' => 'social_facebook', 'value' => '', 'type' => 'text', 'group' => 'social'],
            ['key' => 'social_twitter', 'value' => '', 'type' => 'text', 'group' => 'social'],
            ['key' => 'social_youtube', 'value' => '', 'type' => 'text', 'group' => 'social'],

            // === SEO ===
            ['key' => 'meta_title_home', 'value' => '99web — Criação de Websites Profissionais em Portugal', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'meta_description_home', 'value' => 'Criamos websites modernos, sistemas corporativos e otimização Google Maps. Presença digital profissional a partir de 399€.', 'type' => 'textarea', 'group' => 'seo'],
            ['key' => 'google_analytics_id', 'value' => '', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'google_search_console', 'value' => '', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'facebook_pixel_id', 'value' => '', 'type' => 'text', 'group' => 'seo'],

            // === EMAIL ===
            ['key' => 'notification_email', 'value' => 'geral@99web.pt', 'type' => 'text', 'group' => 'email'],
            ['key' => 'sender_name', 'value' => '99web', 'type' => 'text', 'group' => 'email'],

            // === PACOTE ESSENCIAL ===
            ['key' => 'package_essencial_active', 'value' => '1', 'type' => 'boolean', 'group' => 'packages'],
            ['key' => 'package_essencial_name', 'value' => 'Web Essencial', 'type' => 'text', 'group' => 'packages'],
            ['key' => 'package_essencial_badge', 'value' => 'STARTER', 'type' => 'text', 'group' => 'packages'],
            ['key' => 'package_essencial_price_original', 'value' => '499', 'type' => 'text', 'group' => 'packages'],
            ['key' => 'package_essencial_price_final', 'value' => '399', 'type' => 'text', 'group' => 'packages'],
            ['key' => 'package_essencial_popular', 'value' => '0', 'type' => 'boolean', 'group' => 'packages'],
            ['key' => 'package_essencial_features', 'value' => "Design profissional e responsivo\nAté 5 páginas\nFormulário de contacto\nSEO básico\nEntrega em 7-14 dias\nAlojamento e domínio incluído (1 ano)", 'type' => 'textarea', 'group' => 'packages'],
            ['key' => 'package_essencial_cta_text', 'value' => 'Garantir o meu website', 'type' => 'text', 'group' => 'packages'],

            // === PACOTE CORPORATIVO ===
            ['key' => 'package_corporativo_active', 'value' => '1', 'type' => 'boolean', 'group' => 'packages'],
            ['key' => 'package_corporativo_name', 'value' => 'Web Corporativo', 'type' => 'text', 'group' => 'packages'],
            ['key' => 'package_corporativo_badge', 'value' => 'MAIS POPULAR', 'type' => 'text', 'group' => 'packages'],
            ['key' => 'package_corporativo_price_original', 'value' => '799', 'type' => 'text', 'group' => 'packages'],
            ['key' => 'package_corporativo_price_final', 'value' => '599', 'type' => 'text', 'group' => 'packages'],
            ['key' => 'package_corporativo_popular', 'value' => '1', 'type' => 'boolean', 'group' => 'packages'],
            ['key' => 'package_corporativo_features', 'value' => "Tudo do Essencial +\nAté 10 páginas\nIntegração com redes sociais\nGoogle Maps + Analytics\nBlog integrado\nSuporte prioritário 30 dias", 'type' => 'textarea', 'group' => 'packages'],
            ['key' => 'package_corporativo_cta_text', 'value' => 'Escolher este plano', 'type' => 'text', 'group' => 'packages'],

            // === PACOTE PERSONALIZADO ===
            ['key' => 'package_personalizado_active', 'value' => '1', 'type' => 'boolean', 'group' => 'packages'],
            ['key' => 'package_personalizado_name', 'value' => 'Projetos Personalizados', 'type' => 'text', 'group' => 'packages'],
            ['key' => 'package_personalizado_badge', 'value' => 'CUSTOM', 'type' => 'text', 'group' => 'packages'],
            ['key' => 'package_personalizado_price_original', 'value' => '', 'type' => 'text', 'group' => 'packages'],
            ['key' => 'package_personalizado_price_final', 'value' => 'Sob consulta', 'type' => 'text', 'group' => 'packages'],
            ['key' => 'package_personalizado_popular', 'value' => '0', 'type' => 'boolean', 'group' => 'packages'],
            ['key' => 'package_personalizado_features', 'value' => "Sistemas web à medida\nE-commerce e lojas digitais\nIntegrações com APIs\nDashboards e painéis admin\nManutenção e suporte contínuo", 'type' => 'textarea', 'group' => 'packages'],
            ['key' => 'package_personalizado_cta_text', 'value' => 'Falar sobre o projeto', 'type' => 'text', 'group' => 'packages'],

            // === HERO ===
            ['key' => 'hero_title_line1', 'value' => 'Seus clientes estão', 'type' => 'text', 'group' => 'hero'],
            ['key' => 'hero_title_line2', 'value' => 'à sua procura', 'type' => 'text', 'group' => 'hero'],
            ['key' => 'hero_title_line3', 'value' => 'na internet!', 'type' => 'text', 'group' => 'hero'],
            ['key' => 'hero_subtitle', 'value' => 'Criamos a sua presença online — seja encontrado pelos seus públicos com um site que converte.', 'type' => 'textarea', 'group' => 'hero'],
            ['key' => 'hero_cta_primary', 'value' => 'Marcar revisão do projeto', 'type' => 'text', 'group' => 'hero'],
            ['key' => 'hero_cta_secondary', 'value' => 'Ver casos de sucesso', 'type' => 'text', 'group' => 'hero'],
            ['key' => 'hero_stat1_value', 'value' => '100%', 'type' => 'text', 'group' => 'hero'],
            ['key' => 'hero_stat1_label', 'value' => 'Entregas no prazo', 'type' => 'text', 'group' => 'hero'],
            ['key' => 'hero_stat2_value', 'value' => 'Suporte', 'type' => 'text', 'group' => 'hero'],
            ['key' => 'hero_stat2_label', 'value' => 'Resposta em 24/48h', 'type' => 'text', 'group' => 'hero'],

            // === CTA FINAL ===
            ['key' => 'cta_title', 'value' => 'Pronto para transformar o seu negócio?', 'type' => 'text', 'group' => 'cta'],
            ['key' => 'cta_subtitle', 'value' => 'Fale com a 99web e construa uma presença digital que converte visitantes em clientes.', 'type' => 'textarea', 'group' => 'cta'],
            ['key' => 'cta_button_text', 'value' => 'Vamos conversar', 'type' => 'text', 'group' => 'cta'],
            ['key' => 'cta_disclaimer', 'value' => 'Sem compromisso. Resposta em 24h.', 'type' => 'text', 'group' => 'cta'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
