# HRMS

Human Resource Management System built with Laravel 13, MySQL, Blade and Bootstrap 5.
Built as an SDLC project at Webskitters Academy.

**Status:** Phase 1 (authentication and access control) and Phase 2 (organisation and employees) complete. Attendance and leave modules are planned.

## Features

- Session login and logout, with rate limiting (5 attempts per minute)
- Forgot and reset password (expiring, single-use tokens)
- Role-based access control: 4 roles, permission checks on routes and views
- Forced password change on first login
- Create user: HR or Super Admin creates an account, and a temporary password is sent by email
- Departments and designations: create, list, edit
- Employees: create from an existing user account, list, edit, with auto-generated employee codes (`EMP0001` format)
- Offboarding: HR or Super Admin offboards an employee from the employees list (modal); the account is deactivated and the leaving date recorded. A deactivated user is logged out on their next request.
- Feature tests (PHPUnit, in-memory SQLite): 47 tests, 173 assertions

## Tech stack

Laravel 13, PHP 8.4, MySQL, Blade, Bootstrap 5 (Vite + Sass)

## Setup

```bash
git clone https://github.com/notSinhaSid/HRMS_SDLC_project.git
cd HRMS_SDLC_project
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
| Manager | none | none yet (team view planned) |
| Employee | none | none yet |

Offboarding uses `employee.update`. HR cannot offboard a Super Admin or their own record.

## Tests

```bash
php artisan test
```

Tests use in-memory SQLite and never touch the `hrms` database.

## Known gaps

- Reactivating an offboarded employee is not in the UI yet (Tinker or SQL only).
- A future leaving date still deactivates the account immediately (no scheduled deactivation).
- Attendance, leave, audit trail and payroll modules are not built yet.
