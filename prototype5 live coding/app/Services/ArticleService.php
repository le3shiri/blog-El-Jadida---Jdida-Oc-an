<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArticleService
{
    public function paginate(?int $categoryId = null, int $perPage = 10): LengthAwarePaginator
    {
        return Article::query()
            ->with('category')
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function delete(Article $article): void
    {
        $article->delete();
    }
}
