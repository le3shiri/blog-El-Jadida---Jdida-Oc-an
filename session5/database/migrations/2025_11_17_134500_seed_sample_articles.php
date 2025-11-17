<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = Carbon::now();

        $categoryNames = ['Travel', 'Lifestyle', 'Tech'];

        foreach ($categoryNames as $name) {
            DB::table('categories')->updateOrInsert(
                ['name' => $name],
                ['created_at' => $now, 'updated_at' => $now]
            );
        }

        $categories = DB::table('categories')->pluck('id', 'name');

        DB::table('articles')->insert([
            [
                'title' => 'Discovering El Jadida',
                'category_id' => $categories['Travel'] ?? null,
                'status' => 'published',
                'published_at' => $now->copy()->subDays(3),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Top 5 Oceanfront Cafés',
                'category_id' => $categories['Lifestyle'] ?? null,
                'status' => 'draft',
                'published_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Tech Meetups in El Jadida',
                'category_id' => $categories['Tech'] ?? null,
                'status' => 'published',
                'published_at' => $now->copy()->subWeek(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        DB::table('articles')
            ->whereIn('title', [
                'Discovering El Jadida',
                'Top 5 Oceanfront Cafés',
                'Tech Meetups in El Jadida',
            ])
            ->delete();

        DB::table('categories')
            ->whereIn('name', ['Travel', 'Lifestyle', 'Tech'])
            ->delete();
    }
};
