FROM php:8.1-fpm-alpine

# Arguments defined in docker-compose.yml
ARG user=localize
ARG uid=1000

ARG ssh_prv_key
ARG ssh_pub_key

# Install system dependencies
RUN apk update && apk add \
    git \
    make \
    curl \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip xml

# Get latest Composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN adduser -G www-data -G root -D -u $uid -h /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user /home/$user

# Set working directory
WORKDIR /var/www

COPY . /var/www

RUN composer install

USER $user