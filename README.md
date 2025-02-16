## 🛒 Ideasoft Take-Home Assessment

Bu proje, sipariş yönetimi ve indirim hesaplamalarını içeren bir RESTful API servisidir. Proje PHP'de Laravel php framework kullanılarak geliştirilmiş olup Docker desteğiyle ayağa kaldırılabilir.

## 📌 İçindekiler

- Özellikler
- Kurulum 
- API Kullanımı
- Mimari ve Kullanılan Teknolojiler
- Geliştirme
- İletişim

## 🚀 Özellikler

✔ Sipariş ekleme, silme ve listeleme API'leri
✔ Sipariş eklerken stok kontrolü
✔ Belirli kurallara göre dinamik indirim hesaplama sistemi
✔ Docker ile kolay kurulum
✔ Gelecekte genişletilebilir yapı

## ⚡ Kurulum
1️⃣ Docker Kullanarak Çalıştırma
```
git clone git@github.com:kemalbalaban/take-home.git
cd take-home
docker-compose up -d --build
```
2️⃣ Manuel Kurulum

📌 Gerekli bağımlılıkları yükleyin:
```
composer install
```
📌 Env değişkenlerini tanımlayın:
```
cp .env.example .env
php artisan key:generate
```
📌 Tabloları oluşturun:
```
php artisan migrate --seed
```
📌 Laravel için sunucuyu başlatın:
```
php artisan serve
```
Uygulama varsayılan olarak http://127.0.0.1:8000 adresinde çalışacaktır.

## 📡 API Kullanımı

🔹 Sipariş Ekleme

POST `/api/orders`

```
{
  "customer_id": 1,
  "products": [
    { "product_id": 3, "quantity": 2 },
    { "product_id": 5, "quantity": 1 }
  ]
}
```

🔹 Sipariş Silme

DELETE `/api/orders/{id}`

🔹 Sipariş Listeleme

GET `/api/orders

## 🔧 Mimari ve Kullanılan Teknolojiler

- PHP 8.x
- Laravel 
- MySQL 
- Docker & Docker-Compose
  - node:18

## 📩 İletişim
Bu repo hakkında geri bildirimleriniz veya sorularınız için benimle iletişime geçebilirsiniz:

