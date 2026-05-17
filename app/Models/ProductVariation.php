<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $table = 'product_variations';

    protected $fillable = [
        'product_id',
        'sku',
        'material',
        'color',
        'size',
        'price',
        'stock',
        'image_path',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributeValues()
    {
        return $this->belongsToMany(attribute_values::class, 'variant_attribute_values', 'product_variation_id', 'attribute_value_id');
    }
}
