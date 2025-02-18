<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class DiscountRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'value',
        'category_id',
        'min_quantity',
        'min_order_total'
    ];
}
