# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

A full-stack task management web application built with Laravel 13. Users can register, verify their email, and manage personal tasks with priorities, due dates, and status tracking. The app exposes both a Blade/Alpine.js web UI and a JSON REST API (v1).

Design theme: Apple Glass-morphism inspired UI using Tailwind CSS.

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP 8.3+, Laravel 13 |
| Frontend | Blade templates, Alpine.js v3.4, Tailwind CSS v3.1 |
| Build | Vite 8 + laravel-vite-plugin |
| Auth (web) | Laravel Breeze (username-based, not email) |
| Auth (API) | Laravel Sanctum (token-based) |
| Database | MySQL (dev/prod), SQLite in-memory (tests) |
| Email | SMTP (Gmail configured in dev) |
| Queue/Cache | Database driver |

## Common Commands

```bash
# First-time setup (install deps, generate key, migrate, build assets)
composer setup

# Start dev server (Laravel + queue + logs + Vite hot reload — runs concurrently)
composer dev

# Run tests
composer test

# Production asset build
npm run build

# Vite dev server only
npm run dev

# Database
php artisan migrate
php artisan db:seed
php artisan tinker
```

## Architecture

```
app/
  Http/
    Controllers/
      TaskController.php          # Web CRUD + complete action
      Auth/                       # Breeze auth controllers
      Api/V1/TaskController.php   # API CRUD (Sanctum-authenticated)
    Requests/
      StoreTaskRequest.php        # Task validation (title uniqueness, due_date >= today)
      UpdateTaskRequest.php       # Same rules as Store; title uniqueness ignores current task
      Auth/LoginRequest.php       # Username + password, rate-limited
    Resources/
      TaskResource.php            # API JSON transformer
  Models/
    User.php                      # hasMany(Task), MustVerifyEmail
    Task.php                      # belongsTo(User), status/priority enums, HasFactory
  Notifications/
    CustomVerifyEmail.php         # Custom email verification
  Policies/
    TaskPolicy.php                # Users may only view/edit/delete their own tasks
  Providers/
    AppServiceProvider.php        # Named rate limiters: web (20/min), api-requests (20/min), login (5/min)

database/
  factories/
    UserFactory.php               # Uses username field (not name)
    TaskFactory.php               # States: pending, completed, expired, highPriority

routes/
  web.php      # Dashboard, Task resource routes (auth + verified + throttle:web)
  api.php      # /api/v1/tokens (throttle:login) + /api/v1/tasks (Sanctum + throttle:api-requests)
  auth.php     # Breeze auth routes (POST login has throttle:login)

resources/
  views/
    layouts/   # app.blade.php (authenticated), guest.blade.php (unauthenticated)
    pages/     # welcome.blade.php, dashboard.blade.php
    tasks/     # create, edit, show
    auth/      # login, register, verify-email
  css/app.css  # Tailwind directives only
  js/app.js    # Alpine.js init + axios bootstrap
```

## Database Schema

### users
| Column | Type | Notes |
|---|---|---|
| id | bigint PK | |
| username | string | unique, replaces `name` |
| email | string | unique |
| password | string | hashed |
| email_verified_at | timestamp | nullable |

### tasks
| Column | Type | Notes |
|---|---|---|
| id | bigint PK | |
| user_id | bigint FK | references users.id |
| title | string | unique per user |
| description | text | nullable |
| due_date | date | nullable |
| status | enum | `pending`, `completed`, `expired` |
| priority | enum | `low`, `medium`, `high` |

## API Endpoints (v1)

All endpoints under `/api/v1/`. Task endpoints require `Authorization: Bearer <token>`.

```
POST   /v1/tokens                 # Get API token (username + password)
GET    /v1/tasks                  # List authenticated user's tasks (paginated)
POST   /v1/tasks                  # Create task
GET    /v1/tasks/{task}           # Show task
PATCH  /v1/tasks/{task}           # Update task
DELETE /v1/tasks/{task}           # Delete task (204)
PATCH  /v1/tasks/{task}/complete  # Mark task complete
```

Response shape defined by `TaskResource`: id, title, description, due_date, priority, status, created_at, updated_at.

## Testing

Tests use PHPUnit (class-based — Pest is not installed despite `tests/Pest.php` existing). The test suite runs against an SQLite in-memory database, not MySQL.

```bash
composer test   # clears config cache then runs all tests
```

Test suites:
- `tests/Feature/Auth/` — registration, login, email verification
- `tests/Feature/TaskTest.php` — web task CRUD, ownership policy (403 assertions)
- `tests/Feature/Api/TokenTest.php` — token issuance endpoint
- `tests/Feature/Api/TaskApiTest.php` — all 7 API endpoints with Sanctum auth
- `tests/Unit/` — placeholder

Some auth tests (PasswordConfirmation, PasswordReset) fail due to missing Blade views — these features are intentionally not implemented.

## Key Conventions

- **Login uses `username`, not `email`** — `LoginRequest` authenticates against the `username` field. Do not change auth views or logic to use email without updating the request and User model.
- **TaskPolicy enforces ownership** — `$this->authorize()` is called at the top of every task action in both web and API controllers. `AuthorizesRequests` trait is on the base `Controller` class (added manually — Laravel 13 omits it by default).
- **Rate limiting** — three named limiters defined in `AppServiceProvider::boot()`: `web` and `api-requests` (20 req/min by user ID or IP), `login` (5 req/min by IP). Applied via `throttle:name` middleware on route groups.
- **StoreTaskRequest** validates `due_date` must be today or in the future; `title` must be unique in the tasks table.
- **`composer dev`** runs four concurrent processes (server, queue, pail, vite) via the `concurrently` npm package — do not try to run them separately for development.
- **Sessions, cache, and queues** all use the database driver; ensure migrations are run before starting the dev server.
- **API store returns 201** — Laravel automatically returns HTTP 201 when a `JsonResource` is returned from a POST route. Tests must assert `assertStatus(201)`, not 200.
