#!/bin/sh
set -e

export PORT="${PORT:-8000}"

if [ ! -f .env ]; then
    cp .env.example .env
fi

# Map Railway's MySQL plugin env vars (MYSQLHOST etc.) into the standard DB_* keys
if [ -n "$MYSQLHOST" ]; then
    grep -q '^DB_HOST='     .env && sed -i "s|^DB_HOST=.*|DB_HOST=${MYSQLHOST}|"             .env || printf '\nDB_HOST=%s\n'     "$MYSQLHOST"     >> .env
    grep -q '^DB_PORT='     .env && sed -i "s|^DB_PORT=.*|DB_PORT=${MYSQLPORT}|"             .env || printf '\nDB_PORT=%s\n'     "$MYSQLPORT"     >> .env
    grep -q '^DB_DATABASE=' .env && sed -i "s|^DB_DATABASE=.*|DB_DATABASE=${MYSQLDATABASE}|" .env || printf '\nDB_DATABASE=%s\n' "$MYSQLDATABASE" >> .env
    grep -q '^DB_USERNAME=' .env && sed -i "s|^DB_USERNAME=.*|DB_USERNAME=${MYSQLUSER}|"     .env || printf '\nDB_USERNAME=%s\n' "$MYSQLUSER"     >> .env
    grep -q '^DB_PASSWORD=' .env && sed -i "s|^DB_PASSWORD=.*|DB_PASSWORD=${MYSQLPASSWORD}|" .env || printf '\nDB_PASSWORD=%s\n' "$MYSQLPASSWORD" >> .env
fi

if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

php artisan migrate --force

php artisan storage:link --force 2>/dev/null || true

if [ "${APP_ENV}" = "production" ]; then
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

exec "$@"
