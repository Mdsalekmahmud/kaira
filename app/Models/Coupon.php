<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable =
    [
        'code',
        'type',
        'value',
        'min_amount',
        'expired_at',
        'status',
    ];
}
