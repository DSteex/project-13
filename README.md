## Технический стек
- PHP 8.+
- Laravel 13.8
- PostgreSQL
- Docker (Laravel Sail)

## Для быстрой сборки и запуска проекта используется Makefile.

### Загрузка, инициализация и первый запуск проекта:

- git clone git@github.com:DSteex/Short-URL-Filament.git test

- make init

## Примеры проверки URL
### Проверка через Makefile

- make run-all

### Управление контейнерами

- make up - запустить контейнеры
- make down - остановить контейнеры
- make restart - перезапустить контейнеры
- make migrate - миграции
- make fresh - пересоздать бд (migrate:fresh)
- make clear-cache - очистка маршртутов и конфигурации laravel

- make run-all - запуск всех проверок
- make create-test - геренация short-url
- make redirect-test - проверка редиректа
- make stats-test - проверка записей

## Проверка Filament
### 1. Инициализация

- make init

### 2. Регистрация

- http://localhost/admin/register

### 3. Логин

- http://localhost/admin/login

### 4. Создание ссылки

- http://localhost/admin/links/create
