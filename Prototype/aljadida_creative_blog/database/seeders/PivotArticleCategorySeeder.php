<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;

class PivotArticleCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = Category::pluck('id');

        Article::all()->each(function ($article) use ($categoryIds) {
            if ($categoryIds->isEmpty()) {
                return;
            }

            $article->categories()->sync(
                $categoryIds->random(rand(1, min(3, $categoryIds->count())))->all()
            );
        });
    }
}
