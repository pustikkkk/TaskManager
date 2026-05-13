# Task Manager

A full-stack personal productivity application built with **Laravel 13** and a custom **Apple Glass-morphism UI**. Users register, verify their email, and manage private tasks with priorities, due dates, filtering, and status tracking — all through both a web interface and a REST API.

---

## Try it live

A live demo is available at: `<!-- deployment URL -->`

To explore the app without registering, use these demo credentials:

| Field | Value |
|---|---|
| Username | `<!-- username -->` |
| Password | `<!-- password -->` |

---

## What it does

Users create an account, verify their email address, and land on a personal dashboard where all their tasks live. Each task has a title, optional description, due date, priority level (low / medium / high), and a status that progresses from **pending** → **completed** or **expired**. The dashboard splits tasks into two sections: an active list and a clean archive for anything that is finished or past due.

Everything is scoped to the authenticated user — you can never see or touch another user's tasks.

---

## Features

- **Authentication** — username-based registration and login with email verification (custom email notification), rate-limited to 5 login attempts per minute per IP
- **Task CRUD** — create, view, edit, complete, and delete tasks through a polished web UI
- **Filtering & sorting** — filter the active list by priority and due date window (today / next 7 days / this month); sort by date or priority in either direction; the archived list adds status filtering and six sort options
- **Archive** — completed and expired tasks are separated from the active list automatically; the archive section only appears when there is something to show
- **REST API (v1)** — full token-authenticated API built with Laravel Sanctum, exposing all task operations with consistent JSON responses
- **Authorization** — `TaskPolicy` enforces ownership on every route; a non-owner gets a 403, not a 404 (no data leakage)
- **Rate limiting** — named Laravel rate limiters on all web task routes (20 req/min) and API task routes (20 req/min), plus a stricter 5 req/min guard on the token-issuance endpoint
- **Glass-morphism UI** — responsive, mobile-first design built with Tailwind CSS, Alpine.js, and a consistent translucent-card aesthetic throughout

---

## Tech Stack

| Concern | Technology |
|---|---|
| Backend | PHP 8.3, Laravel 13 |
| Frontend | Blade templates, Alpine.js v3, Tailwind CSS v3 |
| Build tool | Vite 8 + laravel-vite-plugin |
| Web auth | Laravel Breeze (username-based) |
| API auth | Laravel Sanctum (Bearer token) |
| Database | MySQL (development / production) |
| Test database | SQLite in-memory |
| Email | SMTP (Gmail) |
| Queue & cache | Database driver |
| Testing | PHPUnit (class-based) |

---

## API

All task endpoints sit under `/api/v1/` and require an `Authorization: Bearer <token>` header. A token is obtained by posting credentials to `/api/v1/tokens`.

| Method | Endpoint | Description |
|---|---|---|
| `POST` | `/v1/tokens` | Exchange username + password for an API token |
| `GET` | `/v1/tasks` | List the authenticated user's tasks (paginated) |
| `POST` | `/v1/tasks` | Create a task |
| `GET` | `/v1/tasks/{task}` | Retrieve a single task |
| `PATCH` | `/v1/tasks/{task}` | Update a task |
| `DELETE` | `/v1/tasks/{task}` | Delete a task (returns 204) |
| `PATCH` | `/v1/tasks/{task}/complete` | Mark a task as completed |

Every task response includes: `id`, `title`, `description`, `due_date`, `priority`, `status`, `created_at`, `updated_at`.

---

## Database schema

**users** — `id`, `username` (unique), `email` (unique), `password`, `email_verified_at`

**tasks** — `id`, `user_id` (FK → users), `title`, `description`, `due_date`, `status` (pending / completed / expired), `priority` (low / medium / high)

---

## Running locally

```bash
# 1. Install dependencies
composer install && npm install

# 2. Environment
cp .env.example .env
php artisan key:generate

# 3. Configure .env — set DB_* credentials and MAIL_* for email verification

# 4. Migrate and seed
php artisan migrate --seed

# 5. Start everything (Laravel + queue + Vite hot reload — runs concurrently)
composer dev
```

The app will be available at `http://localhost:8000`.

**Run the test suite:**

```bash
composer test
```

Tests use an SQLite in-memory database and cover registration, login, email verification, task CRUD, ownership policy enforcement, and all API endpoints.

---

## Project structure highlights

```
app/
  Http/Controllers/
    TaskController.php          # Web CRUD + complete action
    Api/V1/TaskController.php   # JSON API controller
  Models/
    User.php                    # hasMany(Task), MustVerifyEmail
    Task.php                    # belongsTo(User), status/priority enums
  Policies/
    TaskPolicy.php              # Ownership gate for all task operations
  Providers/
    AppServiceProvider.php      # Named rate limiters (web, api-requests, login)

resources/views/
  pages/                        # welcome, dashboard
  tasks/                        # create, edit, show
  layouts/                      # app (authenticated), guest (unauthenticated)
```

---

## Design decisions worth noting

- **Username over email for login** — users authenticate with a username, not their email address. This keeps the credential set separate from the verification address and matches many real-world apps.
- **Policy-first authorization** — every controller action that touches a specific task calls `$this->authorize()` before doing anything. The policy is the single source of truth for "who can do what."
- **Dual filter state** — the dashboard has two independent filter forms (pending and archive). Hidden inputs carry the other section's state on every submission so neither section loses its filters when the other is changed.
- **Separation of web and API auth** — Breeze handles session-based web login; Sanctum handles stateless token auth for the API. They share the same `User` model and `TaskPolicy` but use different middleware stacks.
