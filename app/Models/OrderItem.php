<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $table = 'order_item';
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'total'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
