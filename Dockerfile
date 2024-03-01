FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid $user && \
    mkdir -p /home/$user && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

# Copy composer.json and composer.lock files to the container
COPY composer.json composer.lock ./

# Install dependencies with Composer
RUN composer install --no-scripts --no-autoloader --no-dev

# Copy the rest of your Laravel application into the container
COPY . .

# Generate the autoloader files
RUN composer dump-autoload --optimize

USER $user
