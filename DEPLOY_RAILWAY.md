# Deploy на Railway.app

Railway сам соберёт и запустит Docker Compose. Бесплатный лимит: $5 кредитов в месяц.

## 1. Подготовить проект

Создай в корне `railway.json`:

```json
{
  "build": {
    "builder": "DOCKERFILE",
    "dockerfilePath": "./backend/Dockerfile"
  },
  "deploy": {
    "numReplicas": 1,
    "startCommand": "php artisan serve --host=0.0.0.0 --port=8000"
  }
}
```

## 2. Залить на GitHub

```bash
git init
git add .
git commit -m "init"
git remote add origin https://github.com/твой-юзер/currency-monitor.git
git push -u origin main
```

## 3. В Railway

1. Зайди на https://railway.app
2. **New Project** → **Deploy from GitHub repo**
3. Выбери репозиторий
4. Railway сам найдёт Dockerfile и соберёт

## 4. Добавить PostgreSQL

- В проекте → **New** → **Database** → **PostgreSQL**
- Railway сам добавит переменные окружения (`PGHOST`, `PGPORT`, `PGDATABASE`, `PGUSER`, `PGPASSWORD`)

## 5. Переменные окружения

В настройках сервиса → **Variables** добавь:

| Variable | Value |
|----------|-------|
| `APP_KEY` | `base64:cqQD0b071DLemCkcb9b6+GK8T5nwJk65dF748nyDzdI=` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `DB_CONNECTION` | `pgsql` |
| `DB_HOST` | `${{Postgres.PGHOST}}` |
| `DB_PORT` | `${{Postgres.PGPORT}}` |
| `DB_DATABASE` | `${{Postgres.PGDATABASE}}` |
| `DB_USERNAME` | `${{Postgres.PGUSER}}` |
| `DB_PASSWORD` | `${{Postgres.PGPASSWORD}}` |
| `MAIL_MAILER` | `smtp` |
| `MAIL_HOST` | `smtp.gmail.com` |
| `MAIL_PORT` | `587` |
| `MAIL_USERNAME` | `mlz.psant@gmail.com` |
| `MAIL_PASSWORD` | `ctnc htve kdiw hjac` |
| `MAIL_ENCRYPTION` | `tls` |
| `MAIL_FROM_ADDRESS` | `mlz.psant@gmail.com` |
| `MAIL_FROM_NAME` | `CurrencyMonitor` |

Railway сам подставит `${{Postgres.PG*}}` значения из сервиса БД.

## 6. Миграции

Добавь секцию `deploy` в `railway.json`:

```json
{
  "build": {
    "builder": "DOCKERFILE",
    "dockerfilePath": "./backend/Dockerfile"
  },
  "deploy": {
    "numReplicas": 1,
    "startCommand": "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000"
  }
}
```

## 7. Запустить

Railway сам выполнит деплой после пуша. На вкладке **Deployments** смотри логи.

## 8. Домен

**Settings** → **Generate Domain** → получишь `currency-monitor.railway.app`

---

## Полезные ссылки

- Dashboard: https://railway.app/dashboard
- Документация: https://docs.railway.com
