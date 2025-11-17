<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ArticleService
{
    public function getPaginatedArticles(?string $category = null, int $perPage = 10): LengthAwarePaginator
    {
        return Article::query()
            ->when($category, fn ($query) => $query->where('category', $category))
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
        return Article::query()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->filter();
    }
}
