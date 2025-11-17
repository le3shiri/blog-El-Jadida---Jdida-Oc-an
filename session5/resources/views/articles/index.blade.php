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
            color-scheme: light;
        }
        body {
            margin: 0;
            padding: 24px;
            background: #f5f6fb;
            color: #0f172a;
        }
        h1 {
            font-size: 28px;
            margin-bottom: 16px;
        }
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 10px 40px rgba(15, 23, 42, 0.08);
        }
        .filter-bar {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-bottom: 20px;
        }
        select {
            padding: 10px 14px;
            border-radius: 10px;
            border: 1px solid #cbd5f5;
            background: #fff;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        th {
            text-align: left;
            font-weight: 600;
            color: #475569;
            padding: 14px;
            border-bottom: 1px solid #e2e8f0;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.04em;
        }
        td {
            padding: 16px 14px;
            border-bottom: 1px solid #f1f5f9;
            background: #fff;
        }
        .status {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }
        .status-published {
            background: #dcfce7;
            color: #15803d;
        }
        .status-draft {
            background: #fef3c7;
            color: #b45309;
        }
        .status-archived {
            background: #fee2e2;
            color: #991b1b;
        }
        .actions button {
            background: #ef4444;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 13px;
            transition: background 0.2s ease;
        }
        .actions button:hover {
            background: #dc2626;
        }
        .empty {
            text-align: center;
            padding: 24px;
            color: #94a3b8;
        }
        .flash {
            background: #ecfdf5;
            border: 1px solid #6ee7b7;
            color: #047857;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 16px;
        }
        .pagination {
            margin-top: 24px;
        }
        .pagination ul {
            list-style: none;
            padding: 0;
            display: flex;
            gap: 8px;
        }
        .pagination a,
        .pagination span {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            min-width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid #cbd5f5;
            text-decoration: none;
            color: #1e1b4b;
            font-weight: 500;
            background: #fff;
        }
        .pagination .active {
            background: #4f46e5;
            color: #fff;
            border-color: #4f46e5;
        }
    </style>
</head>
<body>
<div class="card">
    <h1>Articles</h1>

    @if (session('status'))
        <div class="flash">{{ session('status') }}</div>
    @endif

    <form method="GET" class="filter-bar">
        <label for="category">Category:</label>
        <select id="category" name="category" onchange="this.form.submit()">
            <option value="">All</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected($selectedCategory === $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </form>

    <div class="table-wrapper">
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
            @forelse($articles as $article)
                <tr>
                    <td>{{ $article->id }}</td>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->category->name ?? '—' }}</td>
                    <td>
                        @php
                            $statusClass = 'status-' . strtolower($article->status ?? '');
                        @endphp
                        <span class="status {{ $statusClass }}">
                            {{ ucfirst($article->status) }}
                        </span>
                    </td>
                    <td>{{ optional($article->published_at ?? $article->created_at)->format('M d, Y') }}</td>
                    <td class="actions">
                        <form method="POST" action="{{ route('articles.destroy', $article) }}" onsubmit="return confirmDelete();">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty">No articles found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $articles->links() }}
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this article?');
    }
</script>
</body>
</html>
