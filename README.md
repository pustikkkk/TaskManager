# Task Management System

A full-stack task management application built with Laravel 13 featuring authentication, task tracking, and a REST API. Users can create accounts, verify email addresses, and manage personal tasks with priorities, due dates, and status tracking.

The application includes both a web interface and a fully authenticated API built with Laravel Sanctum.

---

## Live Demo

https://taskmananger-production.up.railway.app/

Demo credentials:

Username: pustikkk  
Password: qonhot-3kumje-Mognuj  

---

## Features

- User authentication with email verification
- CRUD operations for tasks (create, update, delete, complete)
- Task prioritization (low / medium / high)
- Due date tracking with status transitions (pending, completed, expired)
- Task filtering and sorting (priority, date ranges, status)
- Separate active and archived task views
- REST API with token authentication (Laravel Sanctum)
- Strict authorization using policy-based access control
- Rate limiting for web and API routes
- Responsive UI built with Tailwind CSS and Alpine.js

---

## Tech Stack

**Backend:** PHP 8.3, Laravel 13  
**Frontend:** Blade, Alpine.js, Tailwind CSS  
**API:** Laravel Sanctum (token-based authentication)  
**Database:** MySQL (production), SQLite (testing)  
**Build Tool:** Vite  
**Testing:** PHPUnit  
**Email:** SMTP (Gmail)  

---

## API Overview

Base URL: `/api/v1`

- POST `/tokens` – create API token
- GET `/tasks` – list tasks
- POST `/tasks` – create task
- GET `/tasks/{id}` – get task
- PATCH `/tasks/{id}` – update task
- DELETE `/tasks/{id}` – delete task
- PATCH `/tasks/{id}/complete` – mark as completed

All endpoints require:
Authorization: Bearer <token>

---

## Database Schema

- users: id, username, email, password, email_verified_at
- tasks: id, user_id, title, description, due_date, status, priority

---

## Design Highlights

- Policy-based authorization ensures users can only access their own data
- Separate active and archived task states improve UX clarity
- Web auth (Breeze) and API auth (Sanctum) are fully separated but share the same models
- Rate limiting applied to prevent abuse and brute force attempts

---

## Local Setup

```bash
composer install && npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
composer dev

- **Username over email for login** — users authenticate with a username, not their email address. This keeps the credential set separate from the verification address and matches many real-world apps.
- **Policy-first authorization** — every controller action that touches a specific task calls `$this->authorize()` before doing anything. The policy is the single source of truth for "who can do what."
- **Dual filter state** — the dashboard has two independent filter forms (pending and archive). Hidden inputs carry the other section's state on every submission so neither section loses its filters when the other is changed.
- **Separation of web and API auth** — Breeze handles session-based web login; Sanctum handles stateless token auth for the API. They share the same `User` model and `TaskPolicy` but use different middleware stacks.
