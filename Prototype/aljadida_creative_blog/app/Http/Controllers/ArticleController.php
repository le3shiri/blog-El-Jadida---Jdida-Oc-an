<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Services\ArticleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    private ArticleService $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index(Request $request): View
    {
        $categoryId = $request->query('category_id');
        $articles = $this->articleService->getArticlesWithFilters($categoryId, 5);
        $categories = $this->articleService->getAllCategories();

        return view('articles.index', [
            'articles' => $articles,
            'categories' => $categories,
            'currentCategoryId' => $categoryId,
        ]);
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('articles.create', [
            'article' => new Article(),
            'categories' => $categories,
        ]);
    }

    public function store(StoreArticleRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $article = Article::create([
            'user_id' => 1,
            'title' => $data['title'],
            'slug' => $data['slug'],
            'excerpt' => $data['excerpt'] ?? null,
            'content' => $data['content'] ?? null,
            'status' => $data['status'],
        ]);

        if (!empty($data['category_ids'])) {
            $article->categories()->sync($data['category_ids']);
        }

        return redirect()
            ->route('articles.index')
            ->with('success', 'Article créé avec succès.');
    }

    public function edit(Article $article): View
    {
        $categories = Category::orderBy('name')->get();
        $selectedCategories = $article->categories->pluck('id')->toArray();

        return view('articles.edit', [
            'article' => $article,
            'categories' => $categories,
            'selectedCategories' => $selectedCategories,
        ]);
    }

    public function update(UpdateArticleRequest $request, Article $article): RedirectResponse
    {
        $data = $request->validated();

        $article->update([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'excerpt' => $data['excerpt'] ?? null,
            'content' => $data['content'] ?? null,
            'status' => $data['status'],
        ]);

        if (!empty($data['category_ids'])) {
            $article->categories()->sync($data['category_ids']);
        } else {
            $article->categories()->detach();
        }

        return redirect()
            ->route('articles.index')
            ->with('success', 'Article mis à jour avec succès.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $title = $article->title;
        $article->delete();

        return redirect()
            ->route('articles.index')
            ->with('success', "L'article '{$title}' a été supprimé");
    }
}
