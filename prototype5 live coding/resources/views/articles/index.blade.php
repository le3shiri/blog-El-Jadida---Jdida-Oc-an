<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: #0f172a;
            background: #f8fafc;
        }
        body {
            margin: 0;
            padding: 2rem;
            background: #f8fafc;
        }
        .page {
            max-width: 1100px;
            margin: 0 auto;
        }
        h1 {
            font-size: 1.875rem;
            margin-bottom: 1.5rem;
        }
        .card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.1);
            padding: 1.5rem;
        }
        .filters {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        select {
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid #cbd5f5;
            background: #fff;
            font-size: 0.95rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 0.75rem 0.5rem;
            text-align: left;
        }
        th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            border-bottom: 1px solid #e2e8f0;
        }
        tbody tr {
            border-bottom: 1px solid #e2e8f0;
        }
        tbody tr:last-child {
            border-bottom: none;
        }
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.6rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-live {
            color: #16a34a;
            background: #dcfce7;
        }
        .badge-draft {
            color: #f97316;
            background: #ffedd5;
        }
        .actions button {
            border: none;
            background: transparent;
            color: #ef4444;
            cursor: pointer;
            font-weight: 600;
        }
        .status {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
        .status-dot {
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 50%;
        }
        .status-dot.live { background: #16a34a; }
        .status-dot.draft { background: #f97316; }
        .pagination {
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
        }
        .flash {
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            background: #ecfccb;
            color: #365314;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .empty-state {
            text-align: center;
            padding: 2rem 1rem;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="page">
        <h1>Articles</h1>

        @if (session('status'))
            <div class="flash">{{ session('status') }}</div>
        @endif

        <div class="card">
            <form method="GET" action="{{ route('articles.index') }}" class="filters">
                <label>
                    <span style="display:block;font-size:0.85rem;color:#64748b;margin-bottom:0.25rem;">Category</span>
                    <select name="category_id" onchange="this.form.submit()">
                        <option value="">All categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected($selectedCategory === $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($articles as $article)
                        <tr>
                            <td>{{ $article->id }}</td>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->category?->name ?? '—' }}</td>
                            <td>
                                <span class="status">
                                    <span class="status-dot {{ $article->status === 'published' ? 'live' : 'draft' }}"></span>
                                    {{ ucfirst($article->status) }}
                                </span>
                            </td>
                            <td>{{ optional($article->published_at ?? $article->created_at)->format('M d, Y') }}</td>
                            <td class="actions">
                                <form method="POST" action="{{ route('articles.destroy', $article) }}" onsubmit="return confirm('Delete this article?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">No articles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</body>
</html>
