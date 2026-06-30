.PHONY: init up down restart migrate fresh clear-cache run_all create-test redirect-test stats-test

SAIL = ./vendor/bin/sail
URL_BASE = http://localhost

init:
	cp -n .env.example .env || true
	composer install
	$(SAIL) up -d
	$(SAIL) artisan key:generate
	$(SAIL) artisan migrate

up:
	$(SAIL) up -d

down:
	$(SAIL) down -v

restart: down up

migrate:
	$(SAIL) artisan migrate

fresh:
	$(SAIL) artisan migrate:fresh

clear-cache:
	$(SAIL) artisan route:clear
	$(SAIL) artisan config:clear

run_all: create-test redirect-test stats-test
	@echo "Все тесты пройдены"
	@rm -f .short-url

create-test:
	@echo "Генерация случайного URL и создание записи"
	@TINKER_OUTPUT=$$($(SAIL) artisan tinker --execute=" \
		\$$user = \App\Models\User::firstOrCreate(['email' => 'temp@gmail.com'], ['name' => 'temp', 'password' => bcrypt('password')]); \
		\$$faker = \Illuminate\Container\Container::getInstance()->make(\Faker\Generator::class); \
		\$$randomUrl = \$$faker->url; \
		\$$link = \App\Models\Link::create(['user_id' => \$$user->id, 'original_url' => \$$randomUrl, 'code' => \Illuminate\Support\Str::random(6)]); \
		echo \$$link->original_url .PHP_EOL . \$$link->code;"); \
	echo "$$TINKER_OUTPUT" | head -n 1 > .origin-url; \
	echo "$$TINKER_OUTPUT" | tail -n 1 > .short-url; \
	@echo "Оригинальный url: $$(cat .origin-url)"
	@echo "short-url сгенерирован: $(URL_BASE)/$$(cat .short-url)"
	@rm -f .origin-url
	@echo ""

redirect-test:
	@echo "Проверка редиректа"
	@curl -I $(URL_BASE)/$$(cat .short-url)
	@echo ""

stats-test:
	@echo "Проверка записей статистики"
	@$(SAIL) artisan tinker --execute=" \
		\$$link = \App\Models\Link::where('code', '$$(cat .short-url)')->first(); \
		if (\$$link) { \
			\$$click = \$$link->clicks()->latest()->first(); \
			\$$count = \$$link->clicks()->count(); \
			echo 'IP: ' . \$$click->ip_address . PHP_EOL .'Дата/Время: ' . \$$click->created_at . PHP_EOL .'Всего кликов: ' . \$$count; \
		} else { \
			echo 'Ошибка | Ссылка не найдена'; \
		}"
	@echo "\n"