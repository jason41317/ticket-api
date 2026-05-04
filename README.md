# Ticket API (Laravel 11 + AI Summary)

A full-featured Ticket Management REST API built with **Laravel 11**, featuring authentication, filtering, AI-generated summaries, and structured API resources.

---

## Tech Stack

- PHP 8.3 (XAMPP)
- Laravel 11
- MySQL
- AI Services (Prism-ready)
- Composer

---

## Installation Guide (Windows + XAMPP)

### 1. Clone the Project

```bash
git clone <repo-url>
cd ticket-api
composer install
```

---

### 2. Configure Environment

Copy the example environment file:

```bash
copy .env.example .env
```

Update your `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ticket_api
DB_USERNAME=root
DB_PASSWORD=

AI_PRIMARY=openai
AI_FALLBACK_1=gemini
AI_FALLBACK_2=deepseek
AI_FALLBACK_3=huggingface

OPENAI_API_KEY=your_openai_key
GEMINI_API_KEY=your_gemini_key
DEEPSEEK_API_KEY=your_deepseek_key
HF_TOKEN=your_huggingface_token
OLLAMA_URL=http://localhost:11434
```

---

### 3. Generate Key, Run Migrations, Seed Database

```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
```

---

### 4. Run the Server

```bash
php artisan serve
```

The API will be available at:

```
http://127.0.0.1:8000
```

---