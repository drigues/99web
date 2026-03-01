<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $author = AdminUser::first();
        if (! $author) {
            return;
        }

        $categories = BlogCategory::pluck('id', 'slug');

        // Create tags
        $tagNames = ['Laravel', 'SEO', 'Performance', 'UX', 'WordPress', 'Analytics', 'Design', 'Mobile'];
        $tags = collect($tagNames)->map(fn (string $name) => BlogTag::updateOrCreate(
            ['slug' => \Illuminate\Support\Str::slug($name)],
            ['name' => $name]
        ));

        $posts = [
            [
                'title' => '7 Tendências de Web Design para 2026 que Não Pode Ignorar',
                'slug' => '7-tendencias-web-design-2026',
                'excerpt' => 'Descubra as tendências de web design que estão a transformar a experiência digital em 2026 — de layouts immersivos a micro-interações com IA.',
                'category' => 'web-design',
                'tags' => ['Design', 'UX', 'Mobile'],
                'meta_title' => '7 Tendências de Web Design para 2026 | 99web',
                'meta_description' => 'Conheça as 7 tendências de web design mais relevantes para 2026: IA generativa, layouts 3D, design sustentável e muito mais.',
                'published_days_ago' => 2,
                'content' => <<<'HTML'
<h2>O Web Design Está a Mudar — Rapidamente</h2>
<p>O mundo do web design nunca esteve tão dinâmico. Com a evolução constante da tecnologia e as expectativas crescentes dos utilizadores, 2026 traz consigo uma série de tendências que prometem redefinir a forma como interagimos com websites.</p>
<p>Neste artigo, exploramos as 7 tendências mais impactantes que qualquer empresa ou profissional de web design deve ter no radar.</p>

<h3>1. Layouts Immersivos com Scroll 3D</h3>
<p>Os layouts tradicionais estão a dar lugar a experiências mais imersivas. Com a popularização de bibliotecas como GSAP e Three.js, cada vez mais websites utilizam animações 3D e efeitos de paralaxe avançados para criar narrativas visuais que captam a atenção do utilizador desde o primeiro scroll.</p>
<p>Esta tendência é particularmente eficaz em websites de portfólio, marcas de luxo e agências criativas.</p>

<h3>2. IA Generativa no Design</h3>
<p>A inteligência artificial já não é apenas uma ferramenta de backend. Em 2026, a IA generativa está a ser integrada diretamente no processo de design, desde a geração automática de layouts até à personalização dinâmica de conteúdo baseada no comportamento do utilizador.</p>

<h3>3. Micro-Interações Inteligentes</h3>
<p>As micro-interações — pequenas animações que respondem às ações do utilizador — tornaram-se essenciais para uma boa experiência de utilizador. Em 2026, estas interações estão mais sofisticadas, com feedback háptico em dispositivos móveis e transições que tornam a navegação mais intuitiva.</p>

<h3>4. Design Sustentável e Eco-Consciente</h3>
<p>A sustentabilidade digital é uma realidade. Websites mais leves, com menos transferência de dados e otimizados para eficiência energética, não são apenas bons para o ambiente — também oferecem melhor performance e SEO.</p>
<ul>
<li>Imagens otimizadas em formato WebP e AVIF</li>
<li>Carregamento lazy de recursos não essenciais</li>
<li>Hospedagem em servidores alimentados por energia renovável</li>
<li>Menos JavaScript desnecessário</li>
</ul>

<h3>5. Tipografia como Elemento Hero</h3>
<p>A tipografia bold e expressiva continua a dominar. Fontes variáveis permitem transições fluidas entre pesos e estilos, enquanto combinações criativas de serifadas e sans-serif criam hierarquias visuais mais ricas.</p>

<h3>6. Dark Mode como Padrão</h3>
<p>O modo escuro deixou de ser uma opção — é uma expectativa. Em 2026, a maioria dos websites de qualidade oferece alternância entre modos claro e escuro, com paletas cuidadosamente otimizadas para ambos.</p>

<h3>7. Navegação por Gestos e Voz</h3>
<p>Com o aumento de dispositivos touch e assistentes de voz, a navegação tradicional por clique está a ser complementada por gestos e comandos de voz, criando experiências mais acessíveis e naturais.</p>

<h2>Conclusão</h2>
<p>Estas tendências refletem uma indústria em constante evolução, onde a tecnologia e a criatividade se encontram para criar experiências digitais cada vez mais envolventes. Na 99web, acompanhamos estas tendências de perto para garantir que os websites dos nossos clientes estão sempre na vanguarda.</p>
HTML,
            ],
            [
                'title' => 'SEO Local: Como Colocar o Seu Negócio no Topo do Google Maps',
                'slug' => 'seo-local-google-maps',
                'excerpt' => 'Aprenda as melhores estratégias de SEO local para que o seu negócio apareça nos primeiros resultados do Google Maps e pesquisas locais.',
                'category' => 'seo',
                'tags' => ['SEO', 'Analytics'],
                'meta_title' => 'SEO Local: Guia Completo para Google Maps | 99web',
                'meta_description' => 'Guia prático de SEO local: otimize o Google Business Profile, conquiste reviews e domine as pesquisas locais na sua região.',
                'published_days_ago' => 5,
                'content' => <<<'HTML'
<h2>O Que é SEO Local e Porque é Importante</h2>
<p>SEO local é o processo de otimização da presença online do seu negócio para atrair mais clientes a partir de pesquisas locais relevantes. Quando alguém pesquisa "restaurante perto de mim" ou "web designer em Lisboa", o Google prioriza resultados locais — e é aqui que o SEO local faz toda a diferença.</p>
<p>Estudos mostram que 46% de todas as pesquisas no Google têm intenção local, e 88% dos consumidores que fazem uma pesquisa local no telemóvel visitam ou contactam o negócio dentro de 24 horas.</p>

<h3>1. Otimize o Seu Google Business Profile</h3>
<p>O Google Business Profile (antigo Google My Business) é a base do SEO local. Um perfil completo e otimizado aumenta significativamente as suas chances de aparecer no "Local Pack" — os 3 primeiros resultados com mapa que aparecem nas pesquisas locais.</p>
<ul>
<li>Preencha todas as informações: nome, morada, telefone, horário, website</li>
<li>Escolha as categorias corretas para o seu negócio</li>
<li>Adicione fotografias de qualidade regularmente</li>
<li>Publique atualizações e ofertas semanalmente</li>
</ul>

<h3>2. Conquiste e Responda a Reviews</h3>
<p>As avaliações são um dos fatores mais importantes para o ranking local. Negócios com mais reviews positivas e recentes tendem a aparecer mais alto nos resultados. Peça ativamente aos seus clientes satisfeitos que deixem uma avaliação e responda sempre — tanto às positivas como às negativas.</p>

<h3>3. Consistência NAP (Nome, Morada, Telefone)</h3>
<p>A informação do seu negócio deve ser consistente em todos os diretórios e plataformas online. Inconsistências confundem os motores de busca e podem prejudicar o seu ranking.</p>

<h3>4. Conteúdo Local Relevante</h3>
<p>Crie conteúdo que seja relevante para a sua área geográfica. Blog posts sobre eventos locais, parcerias com outros negócios da zona e páginas de destino específicas para cada localização servida são estratégias eficazes.</p>

<h3>5. Otimização Técnica para Local</h3>
<p>Aspetos técnicos como schema markup LocalBusiness, meta tags com localização e um website responsivo e rápido complementam a estratégia de SEO local.</p>

<h2>Resultados Esperados</h2>
<p>Uma estratégia de SEO local bem executada pode resultar num aumento de 200-500% nas impressões locais em 3-6 meses. Na 99web, ajudamos os nossos clientes a implementar estas estratégias e a dominar os resultados de pesquisa na sua região.</p>
HTML,
            ],
            [
                'title' => 'Porque é que o Seu Negócio Precisa de um Website em 2026',
                'slug' => 'porque-negocio-precisa-website-2026',
                'excerpt' => 'Ainda sem website? Descubra porque ter uma presença online profissional é mais importante do que nunca para o sucesso do seu negócio.',
                'category' => 'marketing-digital',
                'tags' => ['UX', 'Mobile'],
                'meta_title' => 'Porque o Seu Negócio Precisa de um Website em 2026',
                'meta_description' => 'Descubra os 6 motivos pelos quais um website profissional é essencial para qualquer negócio em 2026. Credibilidade, vendas e mais.',
                'published_days_ago' => 10,
                'content' => <<<'HTML'
<h2>O Digital Já Não é Opcional</h2>
<p>Em 2026, a questão já não é "preciso de um website?" — é "posso dar-me ao luxo de não ter um?". Com mais de 95% dos consumidores a pesquisar online antes de fazer uma compra, a ausência de um website profissional é equivalente a não existir para uma grande parte do seu público-alvo.</p>

<h3>1. Credibilidade e Primeira Impressão</h3>
<p>O seu website é frequentemente o primeiro contacto que um potencial cliente tem com o seu negócio. Um website profissional, moderno e rápido transmite credibilidade e competência. Por outro lado, um website desatualizado ou a falta dele pode afastar clientes antes mesmo de conhecerem os seus serviços.</p>

<h3>2. Disponível 24/7</h3>
<p>Ao contrário de uma loja física, o seu website está disponível 24 horas por dia, 7 dias por semana. Potenciais clientes podem conhecer os seus serviços, ver o seu portfólio e entrar em contacto a qualquer hora — incluindo fora do horário de expediente, fins de semana e feriados.</p>

<h3>3. Alcance Geográfico Sem Limites</h3>
<p>Um website permite-lhe alcançar clientes muito além da sua localização física. Seja numa cidade vizinha ou noutro país, o seu negócio pode ser encontrado por qualquer pessoa com acesso à internet.</p>

<h3>4. Marketing de Conteúdo e SEO</h3>
<p>Com um website, pode implementar estratégias de marketing de conteúdo através de um blog, otimização SEO e presença nos motores de busca. Estas estratégias atraem tráfego orgânico qualificado — pessoas que estão ativamente à procura dos seus serviços.</p>
<ul>
<li>Blog posts que respondem às dúvidas do seu público</li>
<li>Páginas de serviço otimizadas para palavras-chave relevantes</li>
<li>Portfólio que demonstra a qualidade do seu trabalho</li>
<li>Landing pages para campanhas específicas</li>
</ul>

<h3>5. Integração com Redes Sociais</h3>
<p>As redes sociais são excelentes para visibilidade, mas têm limitações. Um website é o hub central da sua presença digital, onde controla a experiência do utilizador e pode converter visitantes em clientes de forma muito mais eficaz.</p>

<h3>6. Dados e Insights</h3>
<p>Com ferramentas como Google Analytics, um website fornece dados valiosos sobre o comportamento dos seus visitantes — de onde vêm, o que procuram, quanto tempo passam e onde abandonam. Estes insights são fundamentais para tomar decisões informadas sobre o seu negócio.</p>

<h2>O Investimento que se Paga a Si Próprio</h2>
<p>Um website profissional não é uma despesa — é um investimento com retorno mensurável. Na 99web, criamos websites que não são apenas bonitos, mas que são verdadeiras ferramentas de negócio desenhadas para converter visitantes em clientes.</p>
HTML,
            ],
            [
                'title' => 'Laravel vs WordPress: Qual a Melhor Escolha para o Seu Projeto?',
                'slug' => 'laravel-vs-wordpress-melhor-escolha',
                'excerpt' => 'Comparação detalhada entre Laravel e WordPress para ajudá-lo a escolher a plataforma certa para o seu projeto web.',
                'category' => 'tecnologia',
                'tags' => ['Laravel', 'WordPress'],
                'meta_title' => 'Laravel vs WordPress: Comparação Completa | 99web',
                'meta_description' => 'Laravel ou WordPress? Comparamos performance, segurança, escalabilidade e custos para ajudá-lo a escolher a plataforma ideal.',
                'published_days_ago' => 15,
                'content' => <<<'HTML'
<h2>A Eterna Questão: CMS ou Framework?</h2>
<p>Uma das perguntas mais frequentes que recebemos na 99web é: "Devo usar WordPress ou Laravel para o meu projeto?". A resposta, como em muitas questões de tecnologia, é: depende. Ambas as plataformas têm os seus pontos fortes e fracos, e a escolha ideal depende das necessidades específicas do seu projeto.</p>

<h3>WordPress: O Gigante dos CMS</h3>
<p>O WordPress alimenta mais de 40% de todos os websites do mundo, e por boas razões. É uma plataforma madura, com um ecossistema enorme de plugins e temas que permitem criar websites funcionais rapidamente.</p>
<ul>
<li><strong>Prós:</strong> Rápido de implementar, milhares de plugins, fácil gestão de conteúdo, grande comunidade</li>
<li><strong>Contras:</strong> Performance pode degradar com muitos plugins, segurança requer atenção constante, limitado para funcionalidades custom complexas</li>
</ul>

<h3>Laravel: O Framework para Profissionais</h3>
<p>O Laravel é um framework PHP elegante e poderoso que oferece controlo total sobre cada aspeto da aplicação. É a escolha preferida para projetos que necessitam de funcionalidades personalizadas e escalabilidade.</p>
<ul>
<li><strong>Prós:</strong> Performance superior, segurança robusta, total flexibilidade, excelente para APIs e aplicações complexas</li>
<li><strong>Contras:</strong> Requer desenvolvimento custom, tempo de implementação maior, necessita equipa técnica especializada</li>
</ul>

<h3>Comparação Direta</h3>
<p>Em termos de performance, o Laravel supera consistentemente o WordPress em benchmarks, especialmente quando combinado com caching e otimizações. A nível de segurança, o Laravel oferece proteção nativa contra CSRF, SQL injection e XSS, enquanto o WordPress depende mais da manutenção regular e da qualidade dos plugins instalados.</p>

<h3>Quando Escolher WordPress</h3>
<p>O WordPress é ideal para blogs, websites corporativos simples, lojas online com WooCommerce e projetos com orçamento limitado que precisam de estar online rapidamente.</p>

<h3>Quando Escolher Laravel</h3>
<p>O Laravel é a escolha certa para aplicações web complexas, plataformas com integrações específicas, sistemas que necessitam de escalabilidade e projetos onde a performance e segurança são críticas.</p>

<h2>A Nossa Recomendação</h2>
<p>Na 99web, trabalhamos com ambas as tecnologias e recomendamos a mais adequada para cada projeto. Para a maioria dos websites empresariais e portfólios, o Laravel com Filament oferece o melhor equilíbrio entre flexibilidade, performance e facilidade de gestão.</p>
HTML,
            ],
            [
                'title' => 'Como Medir o Sucesso do Seu Website: Métricas que Importam',
                'slug' => 'medir-sucesso-website-metricas',
                'excerpt' => 'Saiba quais as métricas essenciais para avaliar o desempenho do seu website e como usá-las para tomar decisões estratégicas.',
                'category' => 'tutoriais',
                'tags' => ['Analytics', 'SEO', 'Performance'],
                'meta_title' => 'Métricas de Website: Guia Essencial | 99web',
                'meta_description' => 'Guia prático sobre as métricas mais importantes do seu website: tráfego, conversão, bounce rate, Core Web Vitals e mais.',
                'published_days_ago' => 20,
                'content' => <<<'HTML'
<h2>Mais do que Visitas: Medir o que Realmente Conta</h2>
<p>Ter um website bonito é importante, mas como sabe se está realmente a funcionar? A resposta está nos dados. Com as ferramentas certas, pode medir praticamente todos os aspetos do desempenho do seu website e usar esses insights para melhorar continuamente.</p>

<h3>1. Tráfego e Fontes de Tráfego</h3>
<p>O número total de visitantes é importante, mas saber de onde vêm é ainda mais valioso. O Google Analytics 4 divide o tráfego em categorias:</p>
<ul>
<li><strong>Orgânico:</strong> Visitantes que chegam através de motores de busca</li>
<li><strong>Direto:</strong> Quem digita o URL diretamente no browser</li>
<li><strong>Referral:</strong> Tráfego de outros websites que linkam para o seu</li>
<li><strong>Social:</strong> Visitantes vindos de redes sociais</li>
<li><strong>Paid:</strong> Tráfego de campanhas pagas (Google Ads, etc.)</li>
</ul>

<h3>2. Taxa de Conversão</h3>
<p>A taxa de conversão é a percentagem de visitantes que completam uma ação desejada — preencher um formulário, fazer uma compra, subscrever uma newsletter. Uma taxa de conversão média para websites B2B situa-se entre 2% e 5%.</p>

<h3>3. Bounce Rate e Tempo na Página</h3>
<p>O bounce rate indica a percentagem de visitantes que saem do website sem interagir. Um bounce rate elevado pode indicar que o conteúdo não corresponde às expectativas do utilizador ou que o website é lento. O tempo médio na página ajuda a perceber se os visitantes estão realmente a consumir o seu conteúdo.</p>

<h3>4. Core Web Vitals</h3>
<p>Os Core Web Vitals são métricas de performance definidas pelo Google que afetam diretamente o SEO:</p>
<ul>
<li><strong>LCP (Largest Contentful Paint):</strong> Tempo de carregamento do maior elemento visível — deve ser inferior a 2.5 segundos</li>
<li><strong>INP (Interaction to Next Paint):</strong> Responsividade a interações — deve ser inferior a 200ms</li>
<li><strong>CLS (Cumulative Layout Shift):</strong> Estabilidade visual — deve ser inferior a 0.1</li>
</ul>

<h3>5. Páginas Mais Visitadas</h3>
<p>Saber quais páginas recebem mais tráfego ajuda a entender o que o seu público procura e onde investir mais esforço na otimização de conteúdo e conversão.</p>

<h2>Ferramentas Recomendadas</h2>
<p>Para monitorizar estas métricas, recomendamos o Google Analytics 4 para tráfego e conversões, o Google Search Console para performance nos resultados de pesquisa, e o PageSpeed Insights para Core Web Vitals. Na 99web, configuramos todas estas ferramentas para os nossos clientes e fornecemos relatórios mensais com insights acionáveis.</p>
HTML,
            ],
            [
                'title' => 'A Importância da Velocidade: Como um Site Lento Está a Perder Clientes',
                'slug' => 'importancia-velocidade-site-lento-perde-clientes',
                'excerpt' => 'Cada segundo conta: descubra como a velocidade do seu website afeta diretamente as vendas, o SEO e a experiência do utilizador.',
                'category' => 'web-design',
                'tags' => ['Performance', 'SEO', 'UX'],
                'meta_title' => 'Velocidade do Website: Impacto nas Vendas | 99web',
                'meta_description' => 'Saiba como a velocidade do website afeta SEO, conversões e vendas. Dicas práticas para tornar o seu site mais rápido.',
                'published_days_ago' => 27,
                'content' => <<<'HTML'
<h2>3 Segundos é Tudo o que Tem</h2>
<p>Estudos da Google mostram que 53% dos utilizadores móveis abandonam um website que demora mais de 3 segundos a carregar. Num mundo onde a atenção é o recurso mais escasso, cada milissegundo conta.</p>
<p>A velocidade do website não é apenas uma questão técnica — é uma questão de negócio. Afeta diretamente a experiência do utilizador, o posicionamento nos motores de busca e, em última análise, a receita do seu negócio.</p>

<h3>Impacto no SEO</h3>
<p>O Google utiliza a velocidade de carregamento como fator de ranking desde 2010, e com a introdução dos Core Web Vitals, este fator tornou-se ainda mais importante. Websites lentos são penalizados nos resultados de pesquisa, perdendo visibilidade e tráfego orgânico.</p>

<h3>Impacto nas Conversões</h3>
<p>A relação entre velocidade e conversões é clara e mensurável:</p>
<ul>
<li>Um atraso de 1 segundo na resposta da página pode resultar numa redução de 7% nas conversões</li>
<li>Websites que carregam em 1 segundo convertem 3x mais do que websites que carregam em 5 segundos</li>
<li>A Amazon estimou que cada 100ms de atraso custa 1% das vendas</li>
<li>O Walmart reportou um aumento de 2% nas conversões por cada segundo de melhoria na velocidade</li>
</ul>

<h3>Como Diagnosticar Problemas de Velocidade</h3>
<p>Antes de otimizar, é preciso medir. Ferramentas como Google PageSpeed Insights, GTmetrix e WebPageTest fornecem relatórios detalhados sobre a performance do seu website e identificam os principais gargalos.</p>

<h3>Estratégias de Otimização</h3>
<p>Existem várias estratégias comprovadas para melhorar a velocidade do seu website:</p>

<h3>1. Otimização de Imagens</h3>
<p>As imagens são frequentemente o maior peso numa página. Converter para formatos modernos como WebP ou AVIF, implementar lazy loading e usar tamanhos responsivos pode reduzir o peso da página em 50% ou mais.</p>

<h3>2. Caching Eficiente</h3>
<p>Implementar caching a vários níveis — browser cache, server cache e CDN — garante que os visitantes recorrentes têm uma experiência quase instantânea.</p>

<h3>3. Minimizar JavaScript e CSS</h3>
<p>Código não utilizado, bibliotecas desnecessárias e scripts de terceiros podem adicionar segundos ao tempo de carregamento. Auditar e remover código desnecessário é fundamental.</p>

<h3>4. Escolher o Hosting Certo</h3>
<p>Um servidor lento torna todo o resto irrelevante. Investir em hosting de qualidade com SSD, HTTP/3 e localização geográfica próxima dos seus utilizadores é uma das melhorias com maior impacto.</p>

<h2>O Nosso Compromisso com a Performance</h2>
<p>Na 99web, todos os websites que desenvolvemos são otimizados para performance desde o primeiro dia. Utilizamos Vite para bundling, lazy loading para imagens, caching inteligente e hosting premium para garantir que os websites dos nossos clientes carregam em menos de 2 segundos.</p>
HTML,
            ],
        ];

        foreach ($posts as $postData) {
            $categoryId = $categories[$postData['category']] ?? null;
            if (! $categoryId) {
                continue;
            }

            $wordCount = str_word_count(strip_tags($postData['content']));
            $readingTime = (int) max(1, ceil($wordCount / 200));

            $post = BlogPost::updateOrCreate(
                ['slug' => $postData['slug']],
                [
                    'title' => $postData['title'],
                    'excerpt' => $postData['excerpt'],
                    'content' => $postData['content'],
                    'category_id' => $categoryId,
                    'author_id' => $author->id,
                    'meta_title' => $postData['meta_title'],
                    'meta_description' => $postData['meta_description'],
                    'meta_keywords' => implode(', ', array_map(fn ($t) => strtolower($t), $postData['tags'])),
                    'is_published' => true,
                    'published_at' => now()->subDays($postData['published_days_ago']),
                    'reading_time' => $readingTime,
                    'views_count' => rand(15, 250),
                    'featured_image' => null,
                ]
            );

            // Sync tags
            $tagIds = $tags->filter(fn ($tag) => in_array($tag->name, $postData['tags']))->pluck('id');
            $post->tags()->sync($tagIds);
        }
    }
}
