<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'quantity',
        'total_price'
    ];

    public function orderitem()
    {
        return $this->hasMany(OrderItem::class);
    }
}
