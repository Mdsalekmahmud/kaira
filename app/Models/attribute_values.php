<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class attribute_values extends Model
{
    protected $fillable = [
        'attribute_id',
        'value',
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

    public function productVariations()
    {
        return $this->belongsToMany(ProductVariation::class, 'variant_attribute_values', 'attribute_value_id', 'product_variation_id');
    }
}
