# Ticket API (Laravel 11 + AI Summary)

A full-featured Ticket Management REST API built with Laravel 11, featuring authentication, filtering, AI-generated summaries, and structured API resources.

---

# Tech Stack

- PHP 8.3 (XAMPP)
- Laravel 11
- MySQL
- AI Service (Prism-ready)
- Composer

# Installation Guide (Windows + XAMPP)

## 1. Clone project

```bash
git clone <repo-url>
cd ticket-api

composer install

## 2.Configure ENV

copy .env.example .env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ticket_api
DB_USERNAME=root
DB_PASSWORD=


## 3. Generate App Key, migrations and seeder
php artisan key:generate
php artisan migrate
php artisan db:seed

## 4. Run Server
php artisan serve
