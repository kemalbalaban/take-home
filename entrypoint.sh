#!/bin/sh

# Hata durumunda scripti durdur
set -e

# Laravel bağımlılıklarını yükle (eğer vendor klasörü boşsa)
if [ ! -d "vendor" ] || [ -z "$(ls -A vendor)" ]; then
    composer install --no-interaction
fi

# Laravel UI ve Bootstrap Auth Kurulumu
composer require laravel/ui --no-interaction
php artisan ui bootstrap --auth --no-interaction

# Node.js bağımlılıklarını yükle ve build yap
npm install
npm run build  # 'npm run dev' yerine 'npm run build' kullanıyoruz

# .env dosyası kontrolü ve oluşturma
if [ ! -f ".env" ]; then
    cp .env.example .env
    # Veritabanı bağlantısı için bekleme
    sleep 10
fi

# Uygulama anahtarı kontrolü ve oluşturma
if [ -z "$(php artisan key:status)" ]; then
    php artisan key:generate
fi

# Storage link oluştur
php artisan storage:link

# Migrations çalıştır (veritabanına bağlantı varsa)
php artisan migrate --force

# Storage ve cache izinlerini ayarla
chmod -R 777 storage bootstrap/cache

# Laravel'i başlat (CMD'den gelen komutları çalıştır)
exec "$@"