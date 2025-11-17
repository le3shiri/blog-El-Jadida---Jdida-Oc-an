# /articles Prototype Summary

## Created Files

1. `app/Models/Article.php`
   - Eloquent model with fillable fields and datetime cast for `published_at`.

2. `app/Services/ArticleService.php`
   - Encapsulates article pagination, category retrieval, and deletion logic used by the controller.

3. `app/Http/Controllers/ArticleController.php`
   - Uses `ArticleService` for listing and deleting articles, provides flash messages, and passes filter data to the view.

4. `resources/views/articles/index.blade.php`
   - Blade template containing the articles table, category filter dropdown, pagination links, flash messaging, and delete confirmation script.

5. `database/migrations/2025_11_17_133316_create_articles_table.php`
   - Migration defining the `articles` table schema (`title`, `category`, `status`, `published_at`, timestamps).

6. `database/migrations/2025_11_17_134500_seed_sample_articles.php`
   - Migration inserting three representative starter articles and removing them on rollback.

7. `database/seeders/ArticleSeeder.php`
   - Seeder generating 50 realistic sample articles using Faker for titles, categories, statuses, and timestamps.

## Modified Files

1. `database/seeders/DatabaseSeeder.php`
   - Registers `ArticleSeeder` so `php artisan db:seed` populates the articles table.

2. `routes/web.php`
   - Adds resource routing for `articles` (index, destroy) alongside the default welcome route.

## Usage Notes
- Run `php artisan migrate` to apply schema changes and initial sample migration.
- Run `php artisan db:seed` (or `php artisan db:seed --class=Database\Seeders\ArticleSeeder`) to insert the 50 Faker-generated articles.
- Visit `/articles` to interact with the prototype UI (filtering, pagination, delete with confirmation and flash messaging).
