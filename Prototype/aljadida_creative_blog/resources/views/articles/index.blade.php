@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Liste des articles</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-start align-items-center mb-3">
        <form method="GET" action="{{ route('articles.index') }}" class="d-flex align-items-center">
            <label for="category_id" class="me-2">Filtrer par catégorie :</label>
            <select name="category_id" id="category_id" class="form-select me-2" onchange="this.form.submit()">
                <option value="">Toutes</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ (int) $currentCategoryId === $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Catégories</th>
                <th>Statut</th>
                <th>Date de création</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($articles as $article)
                <tr>
                    <td>{{ $article->id }}</td>
                    <td>{{ $article->title }}</td>
                    <td>
                        @foreach ($article->categories as $category)
                            <span class="badge bg-secondary">{{ $category->name }}</span>
                        @endforeach
                    </td>
                    <td>{{ ucfirst($article->status) }}</td>
                    <td>{{ $article->created_at?->format('d/m/Y H:i') }}</td>
                    <td>
                        <form action="{{ route('articles.destroy', $article) }}" method="POST" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer cet article ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Aucun article trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $articles->links() }}
    </div>
</div>
@endsection
