# 99web — Website Institucional

Website institucional e painel de administração para a agência **99web**, construído com Laravel 12.

---

## Stack

| Camada | Tecnologia |
|---|---|
| Backend | PHP 8.2+, Laravel 12 |
| Frontend | Tailwind CSS 4, Alpine.js 3 |
| Bundler | Vite 7 |
| Base de dados | SQLite (dev) · MySQL/PostgreSQL (prod) |
| Imagens | Intervention Image 3 (redimensionamento + WebP) |
| Mail | SMTP (qualquer provedor compatível) |

---

## Instalação rápida

```bash
git clone <repo-url> 99web
cd 99web

# Instalar dependências PHP e Node
composer install
npm install

# Configurar ambiente
cp .env.example .env
php artisan key:generate

# Criar base de dados SQLite (dev) e correr migrações + seeders
touch database/database.sqlite
php artisan migrate --seed

# Ligar storage público (uploads de imagens)
php artisan storage:link

# Build dos assets
npm run build
```

### Iniciar servidor de desenvolvimento

```bash
composer run dev
```

Ou manualmente:

```bash
php artisan serve
npm run dev
```

---

## Credenciais de administração (após seed)

| Campo | Valor |
|---|---|
| URL | `http://localhost:8000/admin` |
| Email | `admin@99web.pt` |
| Password | `password` |

> **Alterar a password após o primeiro login em** `/admin/perfil`.

---

## Estrutura do projeto

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/               # Controladores do painel admin
│   │   │   ├── AdminBlogPostController.php
│   │   │   ├── AdminBlogCategoryController.php
│   │   │   ├── AdminContactController.php
│   │   │   ├── AdminMeetingController.php
│   │   │   ├── AdminPackageRequestController.php
│   │   │   ├── AdminSettingsController.php
│   │   │   ├── AdminProfileController.php
│   │   │   ├── AdminActivityController.php
│   │   │   ├── AdminLoginController.php
│   │   │   └── DashboardController.php
│   │   ├── BlogController.php   # Blog público
│   │   ├── ContactController.php
│   │   ├── HomeController.php
│   │   ├── PackageRequestController.php
│   │   └── SitemapController.php
│   ├── Middleware/
│   │   ├── AdminAuth.php        # Guard do admin
│   │   ├── SecurityHeaders.php  # CSP + headers de segurança
│   │   └── ShareSettings.php    # Partilha $siteSettings com as views
│   └── Requests/                # Form Requests com validação
├── Models/
│   ├── AdminUser.php
│   ├── ActivityLog.php
│   ├── BlogCategory.php
│   ├── BlogPost.php
│   ├── BlogTag.php
│   ├── Contact.php
│   ├── MeetingRequest.php
│   ├── PackageRequest.php
│   └── SiteSetting.php
├── Services/
│   └── SeoService.php           # Meta tags, OG, JSON-LD
├── Mail/                        # Mailable classes
└── Traits/
    └── LogsActivity.php         # Auto-logging em modelos

config/
├── packages.php                 # Definição dos 3 pacotes
└── seo.php                      # Config SEO (Google Analytics ID, etc.)

resources/views/
├── layouts/                     # Layout público
├── partials/                    # Header, footer, nav
├── packages/                    # Páginas de pacotes + formulário
├── blog/                        # Listagem e artigo público
├── home.blade.php
└── admin/
    ├── layouts/admin.blade.php  # Layout do painel admin
    ├── components/              # Componentes x-admin.*
    ├── blog/                    # CRUD de artigos e categorias
    ├── contactos/               # Gestão de contactos
    ├── pedidos/                 # Pedidos de pacotes
    ├── reunioes/                # Pedidos de reunião
    ├── configuracoes/           # Definições do site
    ├── perfil/                  # Perfil do administrador
    └── atividade/               # Registo de atividade
```

---

## Funcionalidades

### Público
- Página inicial com secções: hero, serviços, pacotes, processo, testemunhos, CTA
- **3 pacotes** (Essencial, Corporativo, Personalizado) com formulários de pedido
- Formulário de contacto com resposta automática por email
- **Blog** com listagem, artigo, categorias, tags, RSS feed e sitemap
- SEO completo: meta tags, Open Graph, JSON-LD, sitemap.xml, robots.txt

### Admin (`/admin`)
- **Dashboard** com contadores e notificações
- **Contactos** — lista, detalhe, notas, mudança de estado, exportação CSV
- **Pedidos de Pacotes** — lista, detalhe, notas, mudança de estado, exportação CSV
- **Reuniões** — lista, detalhe, confirmação, notas, exportação CSV
- **Blog** — CRUD completo com editor TinyMCE, upload de imagens WebP, preview, duplicar, publicar/despublicar via AJAX
- **Categorias do Blog** — CRUD com drag & drop para reordenar (SortableJS)
- **Configurações** — 5 tabs: Geral, Redes Sociais, SEO, Email, Pacotes
- **Perfil** — editar nome, email, avatar e alterar password
- **Atividade** — registo das últimas 200 ações do administrador

### Segurança
- Guard de admin separado (`admin_users` table)
- Rate limiting: `/contacto` (30/min), `/pacotes` (20/min), `/login` (10/min)
- Honeypot anti-spam (`_hp` field em formulários públicos)
- Security headers via middleware (CSP, X-Frame-Options, HSTS em produção)
- CSRF em todos os formulários POST

---

## Variáveis de ambiente

Copiar `.env.example` para `.env` e preencher:

```dotenv
APP_NAME=99web
APP_URL=https://99web.pt

# Email de notificações internas
MAIL_ADMIN_ADDRESS=geral@99web.pt
MAIL_FROM_ADDRESS=noreply@99web.pt
MAIL_FROM_NAME="99web"

# Google Analytics (opcional)
GOOGLE_ANALYTICS_ID=G-XXXXXXXXXX
```

Ver `.env.example` para a lista completa.

---

## Comandos úteis

```bash
# Migrações
php artisan migrate
php artisan migrate:fresh --seed   # Reset completo + seed

# Cache (produção)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Limpar cache (desenvolvimento)
php artisan optimize:clear

# Testes
composer run test

# Code style
./vendor/bin/pint
```

---

## Deploy (produção)

1. Configurar `.env` com `APP_ENV=production`, `APP_DEBUG=false`, credenciais reais de BD e SMTP
2. `composer install --no-dev --optimize-autoloader`
3. `npm ci && npm run build`
4. `php artisan migrate --force`
5. `php artisan storage:link`
6. `php artisan config:cache && php artisan route:cache && php artisan view:cache`
7. Configurar worker de queue: `php artisan queue:work --daemon`

### Nginx (exemplo mínimo)

```nginx
server {
    listen 80;
    server_name 99web.pt www.99web.pt;
    root /var/www/99web/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

---

## Licença

Projeto privado — todos os direitos reservados © 99web.
