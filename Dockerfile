FROM php:8.2-cli

# Zaroori softwares aur Node.js install karne ke liye
RUN apt-get update -y && apt-get install -y git unzip nodejs npm

# Composer install karne ke liye
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . /app

# Laravel aur Tailwind ke packages install karne ke liye
RUN composer install
RUN npm install && npm run build

# Render ke port par server chalane ke liye
CMD sh -c "php artisan serve --host=0.0.0.0 --port=\${PORT:-8000}"