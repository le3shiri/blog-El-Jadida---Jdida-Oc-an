<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArticleService
{
    public function getArticlesWithFilters(?int $categoryId = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = Article::with(['categories', 'user'])
            ->orderByDesc('created_at');

        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function getAllCategories()
    {
        return Category::orderBy('name')->get();
    }
}
