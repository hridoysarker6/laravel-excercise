FROM php:8.5-fpm
# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js 22
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*
# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install zip
# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# Set working directory
WORKDIR /var/www/html

# Only copy and install if composer.json exists
RUN if [ -f composer.json ]; then \
    COPY . . && \
    composer install --no-dev --optimize-autoloader; \
    fi

# Set permissions
RUN chown -R www-data:www-data /var/www/html
# Expose port 9000 and start PHP-FPM server
EXPOSE 9000
CMD ["php-fpm"]