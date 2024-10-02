FROM php:8.1-fpm

# Устанавливаем необходимые расширения PHP
RUN docker-php-ext-install pdo_mysql mysqli
# Копируем файлы проекта в директорию /var/www/html
COPY . /var/www/html