<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TagSeeder::class,
            ArticleSeeder::class,
            CategorySeeder::class,
            PivotArticleTagSeeder::class,
            PivotArticleCategorySeeder::class,
        ]);
    }
}
