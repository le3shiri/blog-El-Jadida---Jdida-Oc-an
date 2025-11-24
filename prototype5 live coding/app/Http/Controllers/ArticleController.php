<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Services\ArticleService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct(private readonly ArticleService $articles)
    {
    }

    public function index(Request $request): View
    {
        $categoryId = $request->integer('category_id');

        $articles = $this->articles->paginate($categoryId);
        $categories = Category::orderBy('name')->get();

        return view('articles.index', [
            'articles' => $articles,
            'categories' => $categories,
            'selectedCategory' => $categoryId,
        ]);
    }

    public function destroy(Article $article): RedirectResponse
    {
        $this->articles->delete($article);

        return redirect()
            ->route('articles.index')
            ->with('status', 'Article deleted successfully.');
    }
}
