<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class variant_attribute_values extends Model
{
    protected $fillable = [
        'product_variation_id',
        'attribute_value_id',
    ];

    public function productVariation()
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public function attributeValue()
    {
        return $this->belongsTo(attribute_values::class);
    }
}
