DC=docker-compose
PHP_CONTAINER=php-fpm

# 🔁 Повний цикл: зупиняє старе, будує нове, ставить залежності, піднімає сервіси
start:
	@echo "🧹 Зупиняємо попередні контейнери, якщо такі є..."
	-$(DC) down --remove-orphans

	@echo "🔨 Збираємо образи..."
	$(DC) build --pull --no-cache

	@echo "📦 Встановлюємо залежності..."
	$(DC) run --rm $(PHP_CONTAINER) composer install --no-interaction --prefer-dist

	@echo "🚀 Запускаємо проєкт..."
	$(DC) up -d

# ⛔ Явне зупинення і прибирання
down:
	$(DC) down --remove-orphans
# 🧪 Behat
behat:
	$(DC) exec $(PHP_CONTAINER) vendor/bin/behat

# 🐚 Увійти в bash-контейнер
sh:
	$(DC) exec $(PHP_CONTAINER) bash

.PHONY: start down
