<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function __construct(private readonly ArticleService $articleService)
    {
    }

    public function index(Request $request): View
    {
        $selectedCategory = $request->integer('category');

        $articles = $this->articleService->getPaginatedArticles($selectedCategory ?: null);
        $categories = $this->articleService->getAvailableCategories();

        return view('articles.index', [
            'articles' => $articles,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    public function destroy(int $article): RedirectResponse
    {
        $this->articleService->deleteArticle($article);

        return redirect()
            ->route('articles.index')
            ->with('status', 'Article deleted successfully.');
    }
}
