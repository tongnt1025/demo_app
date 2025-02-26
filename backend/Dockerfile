# Sử dụng image PHP Alpine cho nhẹ
FROM php:8.2-fpm-alpine

# Thêm labels (tùy chọn nhưng tốt cho documentation)
LABEL maintainer="Your Name"
LABEL description="Laravel Production Image"

# Cài đặt dependencies
RUN apk add --no-cache \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    # Thêm một số package cần thiết
    icu-dev \
    oniguruma-dev \
    linux-headers

# Cấu hình và cài đặt PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        gd \
        pdo \
        pdo_mysql \
        zip \
        bcmath \
        opcache \
        intl \
        pcntl \
        mbstring

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Cài đặt opcache
COPY opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Set working directory
WORKDIR /var/www

# Copy composer files đầu tiên để tận dụng Docker cache
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-scripts --no-autoloader --no-dev

# Copy source code
COPY . .

# Generate optimized autoload files
RUN composer dump-autoload --optimize

# Tạo thư mục storage và set permissions
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && mkdir -p storage/logs \
    && chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# Switch to non-root user
USER www-data

EXPOSE 9000

CMD ["php-fpm"]
