<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = Carbon::now();

        DB::table('articles')->insert([
            [
                'title' => 'Discovering El Jadida',
                'category' => 'Travel',
                'status' => 'published',
                'published_at' => $now->copy()->subDays(3),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Top 5 Oceanfront Cafés',
                'category' => 'Lifestyle',
                'status' => 'draft',
                'published_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Tech Meetups in El Jadida',
                'category' => 'Tech',
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
    }
};
