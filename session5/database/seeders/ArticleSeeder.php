<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $faker = FakerFactory::create();
        $categoryNames = ['Travel', 'Lifestyle', 'Tech', 'Food', 'Culture', 'News'];
        $statuses = ['published', 'draft', 'archived'];

        $categoryIds = collect($categoryNames)
            ->mapWithKeys(function (string $name) {
                $category = Category::firstOrCreate(['name' => $name]);

                return [$name => $category->id];
            });

        $records = [];

        for ($i = 1; $i <= 50; $i++) {
            $status = $faker->randomElement($statuses);
            $publishedDate = $status === 'published'
                ? Carbon::instance($faker->dateTimeBetween('-60 days', 'now'))
                : null;
            $timestamp = Carbon::instance($faker->dateTimeBetween('-60 days', 'now'));

            $records[] = [
                'title' => ucfirst($faker->words(mt_rand(3, 6), true)),
                'category_id' => $faker->randomElement($categoryIds->values()->all()),
                'status' => $status,
                'published_at' => $publishedDate,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        }

        Article::insert($records);
    }
}
