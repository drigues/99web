<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Web Design',         'slug' => 'web-design',          'sort_order' => 1],
            ['name' => 'SEO',                 'slug' => 'seo',                 'sort_order' => 2],
            ['name' => 'Marketing Digital',  'slug' => 'marketing-digital',   'sort_order' => 3],
            ['name' => 'Tecnologia',          'slug' => 'tecnologia',          'sort_order' => 4],
            ['name' => 'Tutoriais',           'slug' => 'tutoriais',           'sort_order' => 5],
        ];

        foreach ($categories as $category) {
            BlogCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
