<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $categories = collect([
            'Local News',
            'Lifestyle',
            'Food & Drink',
            'Events',
        ])->mapWithKeys(function (string $name) {
            $category = Category::firstOrCreate(['name' => $name]);

            return [$name => $category->id];
        });

        $articles = [
            [
                'title' => 'Exploring the Old Medina',
                'status' => 'published',
                'category' => 'Lifestyle',
                'days_ago' => 2,
            ],
            [
                'title' => 'Top Seafood Spots by the Corniche',
                'status' => 'published',
                'category' => 'Food & Drink',
                'days_ago' => 5,
            ],
            [
                'title' => 'Weekend Art Fair Highlights',
                'status' => 'draft',
                'category' => 'Events',
                'days_ago' => 8,
            ],
            [
                'title' => 'City Council Approves New Park',
                'status' => 'published',
                'category' => 'Local News',
                'days_ago' => 12,
            ],
            [
                'title' => 'Upcoming Surf Competition Guide',
                'status' => 'draft',
                'category' => 'Events',
                'days_ago' => 15,
            ],
        ];

        foreach ($articles as $article) {
            Article::updateOrCreate(
                ['title' => $article['title']],
                [
                    'category_id' => $categories[$article['category']],
                    'status' => $article['status'],
                    'published_at' => $article['status'] === 'published'
                        ? Carbon::now()->subDays($article['days_ago'])
                        : null,
                    'body' => Str::of($article['title'])->append(' content coming soon!'),
                ]
            );
        }
    }
}
