FROM php:8.2-fpm

# Node.js ve npm kurulumu ekleyelim (Vite için gerekli)
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get update && apt-get install -y \
    nodejs \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql mbstring zip exif pcntl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Composer kurulumu
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Çalışma dizini
WORKDIR /var/www

# Önce package.json ve composer.json dosyalarını kopyala
COPY package*.json composer.* ./

# Bağımlılıkları yükle
RUN composer install --no-scripts --no-autoloader
RUN npm install

# Proje dosyalarını kopyala
COPY . .

# Composer autoload'u optimize et
RUN composer dump-autoload --optimize

# Build dizinini oluştur ve izinleri ayarla
RUN mkdir -p /var/www/public/build
RUN chmod -R 777 storage bootstrap/cache public/build

# Entrypoint script'ini kopyala ve çalıştırılabilir yap
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Entrypoint ve CMD tanımla
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]