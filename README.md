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

<table>
    <thead>
        <tr>
            <td>TASK</td>
            <td>METHOD</td>
            <td>URL</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Sipariş Listesi</td>
            <td>GET</td>
            <td>/api/orders</td>
        </tr>
        <tr>
            <td>Sipariş Silme</td>
            <td>DELETE</td>
            <td>/api/orders/{id}</td>
        </tr>
        <tr>
            <td>Sipariş Oluşturma</td>
            <td>POST</td>
            <td>/api/orders</td>
        </tr>
        <tr>
            <td>İndirim Roller Listesi</td>
            <td>GET</td>
            <td>/api/discounts/rules</td>
        </tr>
        <tr>
            <td>İndirim Tanımlama</td>
            <td>POST</td>
            <td>/api/discounts/{order_id}</td>
        </tr>
    </tbody>
</table>

```
## CREATE ORDER EXAMPLE POST JSON BODY ##
{
  "customer_id": 1,
  "items": [
    { "product_id": 3, "quantity": 2 },
    { "product_id": 5, "quantity": 1 }
  ]
}
```

[Postman İçe Aktar Dosyası](./Orders.postman_collection.json)

## 🔧 Mimari ve Kullanılan Teknolojiler

- PHP 8.x
- Laravel 
- MySQL 
- Docker & Docker-Compose
  - node:18

## 📩 İletişim
Bu repo hakkında geri bildirimleriniz veya sorularınız için benimle iletişime geçebilirsiniz:


kemalbalaban@gmail.com
