# Live Coding Playbook – `/articles` Prototype



## 1. Explain Architecture
- Laravel MVC + Service layer.
- `ArticleController` delegating to `ArticleService`.
- `Category` table powering dropdown + FK constraint.

## 2. Coding Flow 
1. **Model & Migration**
   - Show `app/Models/Article.php` and `database/migrations/2025_11_17_133316_create_articles_table.php`.
   - Highlight `category_id` FK + `published_at` cast.
2. **Service Layer**
   - Walk through `app/Services/ArticleService.php` (pagination, filtering, deletion, categories list).
3. **Controller**
   - `ArticleController@index` retrieving filters, `destroy` flashing success.
4. **Routes**
   - `routes/web.php` resource registration (`index`, `destroy`).
5. **Blade View**
   - `resources/views/articles/index.blade.php`: dropdown, table, pagination, JS confirm.
6. **Seeders**
   - Mention `database/migrations/2025_11_17_134500_seed_sample_articles.php` + `database/seeders/ArticleSeeder.php` for 50 Faker records.

## 3. Live Demo Script
1. Load `/articles` – show seeded data.
2. Filter by category (dropdown auto-submit).
3. Paginate through results.
4. Delete an article (confirm dialog + flash message).


