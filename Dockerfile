# ----------------------------------------------------------------
# Base layer
# ----------------------------------------------------------------

FROM php:fpm-alpine3.15

# Install the packages you need
RUN set -ex \
    && apk update \
    # Add system dependencies
    && echo "Add system dependencies" \
    && apk add --no-cache \
        screen \
        alpine-sdk \
        libpng-dev \
        oniguruma-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        libzip-dev \
        zip \
        jpegoptim optipng pngquant gifsicle \
        vim \
        unzip \
        curl \
        openssh-server \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    # Install PHP Extensions
    && echo "Install PHP Extensions" \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl gd sockets \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    # Configure user
    && addgroup -S www  \
    && adduser -S www -G www \
    # Create composer install directory
    && mkdir -p /var/www/.composer/cache/vcs \
    && chown -R www:www /var/www/.composer

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
RUN chown -R www:www /var/www

# Create an empty .env file to make symfony happy
RUN touch /var/www/.env

# Change current user to www
USER www

# Set your working directory
WORKDIR /var/www
