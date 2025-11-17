<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ArticleService
{
    public function getPaginatedArticles(?int $categoryId = null, int $perPage = 10): LengthAwarePaginator
    {
        return Article::query()
            ->with('category')
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function deleteArticle(int $articleId): void
    {
        $article = Article::findOrFail($articleId);
        $article->delete();
    }

    public function getAvailableCategories(): Collection
    {
        return Category::query()
            ->orderBy('name')
            ->get();
    }
}
