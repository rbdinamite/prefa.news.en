# Prefa News

Prefa News is a lightweight PHP web app that **aggregates and ranks positive municipal news** (public initiatives and policies), making it easier for citizens to discover what their city is doing and for public managers to benchmark successful ideas across municipalities.

## What’s in this repo

- **Web app**: `public/index.php` renders the homepage via `templates/layout.php`
- **API endpoints** (JSON):
  - `GET /api/news.php?page=0` returns paginated news
  - `POST /api/news-url.php` with body `{"id":123}` returns the original article URL
- **Fetcher job**: `php bin/fetch-news.php` pulls RSS items, processes them, and stores them
- **Storage**: SQLite database file under `database/` (configured by `.env`)
- **Config**: `config/config.php` loads environment variables via `vlucas/phpdotenv`

## Requirements

- **PHP**: 8.0+ recommended (must include PDO + SQLite driver)
- **Composer**: for dependencies
- **Web server**: Apache (XAMPP), Nginx, or PHP’s built-in server for local development

## Quick start (local)

### 1) Install dependencies

```bash
composer install
```

### 2) Configure environment

Create your local `.env` file from the example:

```bash
cp .env.example .env
```

Set values in `.env` (minimum required by `config/config.php`):

```dotenv
DB_FILENAME=news.db
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
LOG_PATH=storage/logs
TRANSLATE_SOURCE=pt
TRANSLATE_TARGET=en
```

Notes:
- **`DB_FILENAME`** is the filename inside the `database/` directory.
- **`LOG_PATH`** is relative to the repository root; logs are written to `storage/logs/YYYYMMDD/`.

### 3) Create the SQLite database

If you don’t have a database yet, create one and apply the schema in `database/news.db.example.sql`.

Example (SQLite CLI):

```bash
sqlite3 "database/news.db" < "database/news.db.example.sql"
```

### 4) Run the app

Run with PHP’s built-in server:

```bash
php -S localhost:8000 -t public
```

Then open `http://localhost:8000`.

If you use **XAMPP/Apache**, set the document root to `public/` (not the repository root).

## Fetching / updating news

Run the fetcher job manually:

```bash
php bin/fetch-news.php
```

Typical production setup is a cron job (example, every 30 minutes):

```cron
*/30 * * * * php /path/to/prefa.news.en/bin/fetch-news.php
```

## API

### `GET /api/news.php`

- **Query params**:
  - **`page`**: 0-based page index (default: 0)
- **Response**:
  - `{ "data": [...], "page": 0 }`

Example:

```bash
curl "http://localhost:8000/api/news.php?page=0"
```

### `POST /api/news-url.php`

- **Body**: JSON `{ "id": 123 }`
- **Response**:
  - `{ "url": "https://..." }` or an error with proper HTTP status codes (400/404/405)

Example:

```bash
curl -X POST "http://localhost:8000/api/news-url.php" ^
  -H "Content-Type: application/json" ^
  -d "{\"id\":123}"
```

## Project structure

```
bin/                  CLI jobs (fetcher)
config/               Configuration loader (dotenv -> config array)
database/             SQLite db file + example schema
public/               Web root (index.php + /api endpoints + assets)
src/                  App code (Api, Database, Logger, Processor, Repository, Service, Template)
storage/              Logs/cache (local runtime output)
templates/            Layout and view templates
```

## Development

### Static analysis / linting

Dev dependencies include PHPStan and PHP_CodeSniffer:

```bash
vendor/bin/phpstan analyse src
vendor/bin/phpcs src
```

## Contributing

- **Issues**: open an issue for bugs, enhancements, or ideas.
- **Pull requests**: keep PRs small and focused; include a clear description and a quick test plan.
- **Security**: do not commit secrets. `.env` is ignored by default.

## License

This repository **does not currently include a `LICENSE` file**. For open-source distribution, add a license file (for example, MIT/Apache-2.0/GPL) and update this section accordingly.

## Maintainers / contact

- Roberto Bento — `robertoabreubento@gmail.com`