<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $xml = Cache::remember('sitemap_xml', 3600, function () {
            $posts = BlogPost::published()
                ->select(['slug', 'updated_at'])
                ->latest('published_at')
                ->get();

            $categories = BlogCategory::select(['slug', 'updated_at'])->get();

            return view('sitemap', compact('posts', 'categories'))->render();
        });

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    public function robots(): Response
    {
        $content  = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin\n";
        $content .= "\n";
        $content .= 'Sitemap: ' . route('sitemap') . "\n";

        return response($content, 200, ['Content-Type' => 'text/plain']);
    }
}
