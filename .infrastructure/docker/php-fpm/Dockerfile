FROM php:fpm AS dev

WORKDIR /app

# 🧰 Залежності
RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip zip curl libzip-dev libicu-dev libpq-dev libxml2-dev librabbitmq-dev libsqlite3-0 postgresql-client autoconf $PHPIZE_DEPS \
 && docker-php-ext-install pdo pdo_pgsql intl sockets zip pcntl \
 && pecl install redis apcu excimer amqp-1.11.0 \
 && docker-php-ext-enable redis apcu excimer amqp \
 && echo "apc.enable_cli=1" >> /usr/local/etc/php/conf.d/docker-php-ext-apcu.ini \
 && apt-get purge -y $PHPIZE_DEPS \
 && apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/*

#PHP-pgsql-client
RUN apt-get update && apt-get install -y \
    lsb-release wget gnupg curl \
 && echo "deb http://apt.postgresql.org/pub/repos/apt $(lsb_release -cs)-pgdg main" > /etc/apt/sources.list.d/pgdg.list \
 && wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | apt-key add - \
 && apt-get update \
 && apt-get install -y postgresql-client-17 \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*

# Install Xdebug
RUN apt-get update && apt-get install -y --no-install-recommends $PHPIZE_DEPS \
    && pecl install xdebug-3.4.3 \
    && docker-php-ext-enable xdebug \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request = yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.log_level = 0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.output_dir = '/var/www/xa/cache/xdebug'" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port = 9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && apt-get purge -y $PHPIZE_DEPS \
    && apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/*

# 📦 Composer
RUN curl -sS https://getcomposer.org/composer-stable.phar -o /usr/bin/composer \
 && chmod +x /usr/bin/composer

# 🧩 Копіюємо тільки composer.* файли для залежностей
COPY composer.json composer.lock ./

# 🔁 Тепер копіюємо весь проект (щоб не ламати кеш до install)
COPY . .

# 🧷 Якщо немає .env — створюємо його з example
RUN test -f .env || cp .env.example .env

# 📂 Гарантуємо наявність папок кешу/логів
RUN mkdir -p var/cache var/log

# Тепер composer install зі скриптами
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# 🧹 На випадок, якщо скрипти були вимкнені — прогріваємо кеш вручну
RUN php bin/console cache:clear --no-interaction || true \
 && php bin/console cache:warmup --no-interaction || true

# 👤 Користувач app
RUN groupadd -g 1000 app && useradd -u 1000 -ms /bin/bash -g app app \
 && chown -R app:app /app

USER app

CMD ["php-fpm"]
