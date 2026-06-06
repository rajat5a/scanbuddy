FROM php:8.2-cli

# 1. Zaroori system tools install karna
RUN apt-get update -y && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    nodejs \
    npm

# 2. Laravel ke liye zaroori PHP extensions install karna
RUN docker-php-ext-install pdo_mysql mbstring xml zip

# 3. Composer install karna
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. App directory set karna aur code copy karna
WORKDIR /app
COPY . /app

# 5. Laravel packages install karna
RUN composer install --ignore-platform-reqs --no-interaction

# 6. Tailwind aur Alpine.js build karna
RUN npm install && npm run build

# 7. Server start karna
CMD sh -c "php artisan serve --host=0.0.0.0 --port=\${PORT:-8000}"