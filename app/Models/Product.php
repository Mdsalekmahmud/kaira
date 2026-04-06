<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   protected $fillable =[
    'category_id',
    'slug',
    'name',
    'image',
    'images',
    'discription',
    's_discription',
    'quantity',
    'price',
    's_price',
    'rating',
];

protected $casts=[
'images'=>"array",
];
 
public function category()
{
    return $this->belongsTo(Category::class);
}
// public function orders()
//     {
//         return $this->belongsToMany(Order::class, 'order_products')
//                     ->withPivot(['quantity', 'price', 'total'])
//                     ->withTimestamps();
//     }
}
