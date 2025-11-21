<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Plages & Océan', 'slug' => Str::slug('Plages & Océan')],
            ['name' => 'Cité Portugaise', 'slug' => Str::slug('Cité Portugaise')],
            ['name' => 'Gastronomie Doukkala', 'slug' => Str::slug('Gastronomie Doukkala')],
            ['name' => 'Vie Locale', 'slug' => Str::slug('Vie Locale')],
            ['name' => 'Art & Culture', 'slug' => Str::slug('Art & Culture')],
            ['name' => 'Events & Festivals', 'slug' => Str::slug('Events & Festivals')],
            ['name' => 'Surf & Aventure', 'slug' => Str::slug('Surf & Aventure')],
            ['name' => 'Histoire & Patrimoine', 'slug' => Str::slug('Histoire & Patrimoine')],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                ['name' => $category['name']]
            );
        }
    }
}
