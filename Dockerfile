FROM php:8.2-fpm

# Instalace systémových závislostí a rozšíření
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo_mysql zip

# Nastavení pracovního adresáře
WORKDIR /var/www/html

# Kopírování aplikace
COPY . .

# Nastavení práv
RUN chown -R www-data:www-data /var/www/html

# Exponování portu
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]