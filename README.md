# Currency Monitor — проект

## Архитектура

```
Vue 3 (Vite)  →  /api прокси  →  Laravel (API)  →  PostgreSQL
     |                                  |
  порт 5173                         порт 8001
```

## Стек

- **Frontend**: Vue 3 + Vue Router + Pinia + Chart.js (vue-chartjs) + Vite
- **Backend**: Laravel 13 + PHP 8.4
- **Database**: PostgreSQL 16
- **Email**: Gmail SMTP
- **Инфраструктура**: Docker Compose (4 сервиса)

## Структура

```
second-project-vue/
├── docker-compose.yml        # db + backend + cron + frontend
├── backend/
│   ├── Dockerfile
│   ├── .env                  # настройки БД, почты
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/CurrencyAlertController.php
│   │   │   └── Requests/CurrencyRequest.php
│   │   ├── Console/Commands/CheckCurrencyRate.php
│   │   └── Models/CurrencyAlert.php
│   ├── database/migrations/  # currency_alerts таблица + unique index
│   ├── resources/views/welcome.blade.php
│   └── routes/
│       ├── web.php           # POST /api/alert, GET /
│       └── console.php       # schedule: currency:check hourly
├── src/
│   ├── pages/
│   │   ├── HomePage.vue      # Super IT презентация
│   │   ├── CurrencyPage.vue  # курсы, график, уведомления
│   │   └── NotesPage.vue     # CRUD заметок
│   ├── components/
│   │   └── ModalWindow.vue
│   ├── stores/
│   │   └── notes.js          # Pinia store
│   ├── composables/
│   │   └── useTheme.js       # тёмная тема
│   ├── App.vue
│   └── main.js
├── vite.config.js            # /api → http://backend:8000
├── DEPLOY_ORACLE.md          # инструкция Oracle Cloud
└── DEPLOY_RAILWAY.md         # инструкция Railway.app
```

## Запуск (локально)

```bash
docker compose up -d --build  # всё одной командой
```

- Frontend: http://localhost:5173
- Laravel: http://localhost:8001
- PostgreSQL: localhost:5432, user `user`, password `user`, database `app`

## Проверка курса

```bash
docker compose exec cron php artisan currency:check
```

Scheduler сам запускает команду каждый час.

## API

```
POST /api/alert
Content-Type: application/json

{
  "email": "user@example.com",
  "currency": "USD",
  "threshold": 3.50
}
```

Валидация: email, currency (строка 3 символа), threshold (0.01 — 999999.99).
Upsert по паре (email + currency).

## Email

- SMTP: Gmail (пароль приложения)
- Письмо приходит когда курс достигает порога (раз в день)
- Тема: "CurrencyMonitor — курс USD достиг порога"

## Страницы

| URL | Страница |
|-----|----------|
| `/` | HomePage — Super IT презентация |
| `/notes` | NotesPage — CRUD заметок (Pinia) |
| `/currency` | CurrencyPage — курсы валют, график, уведомления |
