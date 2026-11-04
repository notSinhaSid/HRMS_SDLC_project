# HRMS

Human Resource Management System built with Laravel 13, MySQL, Blade and Bootstrap 5.
Built as an SDLC project at Webskitters Academy.

**Status:** Phase 1 (authentication and access control) complete. Employee, attendance and leave modules are planned.

## Features (Phase 1)

- Session login and logout, with rate limiting (5 attempts per minute)
- Forgot and reset password (expiring, single-use tokens)
- Role-based access control: 4 roles, permission checks on routes and views
- Forced password change on first login
- Create user: HR or Super Admin creates an account, and a temporary password is sent by email
- Feature tests (PHPUnit, in-memory SQLite)

## Tech stack

Laravel 13, PHP 8.4, MySQL, Blade, Bootstrap 5 (Vite + Sass)

## Setup

```bash
git clone TODO-repo-url
cd TODO-folder
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Create an empty MySQL database, then set `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD` in `.env`.

```bash
php artisan migrate --seed
npm run dev
php artisan serve
```

Open http://localhost:8000 and log in with the Super Admin credentials from your `.env`.

## Environment

| Key | Purpose |
|---|---|
| `DB_*` | MySQL connection |
| `SUPERADMIN_*` | TODO: list exact keys. Credentials for the first Super Admin, used by the seeder |
| `MAIL_MAILER` | `log` writes emails to `storage/logs/laravel.log` (useful locally) |

The Super Admin credentials are only used when the account does not exist yet.
Use a strong password in production.

## Roles and permissions

| Role | Can create | Permissions |
|---|---|---|
| Super Admin | HR, Manager, Employee | Everything (bypasses permission checks) |
| HR | Manager, Employee | `employee.view`, `employee.create`, `employee.update`, `employee.delete` |
| Manager | none | none yet (team view planned for Phase 2) |
| Employee | none | none yet |

## Tests

```bash
php artisan test
```

Tests use in-memory SQLite and never touch the `hrms` database.

## Known gaps

- Activating or deactivating a user is not in the UI yet (Tinker only). Planned for Phase 2.
- Employee, department, attendance and leave modules are not built yet.