<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Laravel',
            'PHP',
            'Backend',
            'Frontend',
            'API',
            'DevOps',
            'Testing',
            'Design',
            'UX',
            'UI',
        ];

        foreach ($names as $name) {
            Tag::firstOrCreate(
                ['name' => $name],
                ['slug' => Str::slug($name)]
            );
        }
    }
}
