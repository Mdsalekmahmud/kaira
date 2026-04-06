<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable =[
        'user_id',
        'sub_total',
        'tax',
        'delivery_crg',
        'vat',
        'discount',
        'total_amount',
        'status',
        'payment_method',
        'payment_status',
        'transaction_id',
        'shipping_info',
        'coupon_code',
    ];

    protected $casts=[
        'shipping_info'=>"array",
    ];

     public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
                    ->withPivot(['quantity', 'price', 'total'])
                    ->withTimestamps();
    }
}
