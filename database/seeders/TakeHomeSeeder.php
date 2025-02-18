<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\DiscountRule;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TakeHomeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $customers = [
            ['name' => 'Türker Jöntürk', 'since' => Carbon::parse('2014-06-28'), 'revenue' => 492.12],
            ['name' => 'Kaptan Devopuz', 'since' => Carbon::parse('2015-01-15'), 'revenue' => 1505.95],
            ['name' => 'İsa Sonuyumaz',  'since' => Carbon::parse('2016-02-11'), 'revenue' => 0.00]
        ];
        Customer::insert($customers);

        $products = [
            ['name' => 'Black&Decker A7062 40 Parça Cırcırlı Tornavida Seti', 'category' => 1, 'price' => 120.75, 'stock' => 10],
            ['name' => 'Reko Mini Tamir Hassas Tornavida Seti 32\'li', 'category' => 1, 'price' => 49.50, 'stock' => 10],
            ['name' => 'Viko Karre Anahtar - Beyaz', 'category' => 2, 'price' => 11.28, 'stock' => 10],
            ['name' => 'Legrand Salbei Anahtar, Alüminyum', 'category' => 2, 'price' => 22.80, 'stock' => 10],
            ['name' => 'Schneider Asfora Beyaz Komütatör', 'category' => 2, 'price' => 12.95, 'stock' => 10],
        ];
        Product::insert($products);

        $orders = [
            ['customer_id' => 1, 'total' => 112.80],
            ['customer_id' => 2, 'total' => 219.75],
            ['customer_id' => 3, 'total' => 1275.18],
        ];
        Order::insert($orders);

        // order 1
        OrderItem::create([
            'order_id' => 1,
            'product_id' => 3,
            'quantity' => 10,
            'unit_price' => 11.28,
            'total' => 112.80
        ]);

        // order 2
        OrderItem::create([
            'order_id' => 2,
            'product_id' => 2,
            'quantity' => 2,
            'unit_price' => 49.50,
            'total' => 99.00
        ]);

        OrderItem::create([
            'order_id' => 2,
            'product_id' => 1,
            'quantity' => 1,
            'unit_price' => 120.75,
            'total' => 120.75
        ]);

        // order 3
        OrderItem::create([
            'order_id' => 3,
            'product_id' => 1,
            'quantity' => 6,
            'unit_price' => 11.28,
            'total' => 67.68
        ]);

        OrderItem::create([
            'order_id' => 3,
            'product_id' => 1,
            'quantity' => 10,
            'unit_price' => 120.75,
            'total' => 1207.50
        ]);

        DiscountRule::create([
            'name' => '1000 TL ve Üzeri %10 İndirim',
            'type' => 'percentage',
            'value' => 10,
            'min_order_total' => 1000
        ]);

        DiscountRule::create([
            'name' => 'Kategori 2: 6 Adet Alana 1 Bedava',
            'type' => 'free_item',
            'category_id' => 2,
            'min_quantity' => 6
        ]);

        DiscountRule::create([
            'name' => 'Kategori 1: En Ucuz Ürüne %20 İndirim',
            'type' => 'percentage',
            'value' => 20,
            'category_id' => 1,
            'min_quantity' => 2
        ]);
    }

}
