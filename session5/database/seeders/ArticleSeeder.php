<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $faker = FakerFactory::create();
        $categoryNames = [
            'Plages & Océan',
            'Art & Culture Mazaganaise',
            'Gastronomie Doukkala',
            'Vie Locale & Portraits',
            'Événements & Festivals',
            'Histoire & Patrimoine'
        ];
        $statuses = ['published', 'draft', 'archived'];

        $headlinePrefixes = [
            'Chroniques d\'Al Jadida',
            'Secrets de la Cité Portugaise',
            'Évasion sur la Corniche',
            'Balades Doukkalies',
            'Carnet de plage Mazagan',
            'Escapade gourmande à Hay Essalam',
            'Vibes culturelles d\'El Jadida',
            'Agenda Océanique'
        ];

        $headlineSuffixes = [
            'les expériences à vivre absolument',
            'adresses locales à tester cette semaine',
            'rencontres inspirantes et initiatives solidaires',
            'saveurs traditionnelles revisitées',
            'balades historiques au coucher du soleil',
            'bons plans surf et sports nautiques',
            'coulisses des festivals doukkalis',
            'itinéraires pour redécouvrir la médina'
        ];

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
                'title' => sprintf(
                    '%s — %s',
                    Arr::random($headlinePrefixes),
                    Arr::random($headlineSuffixes)
                ),
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
