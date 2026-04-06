<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ServiceTax extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'TaxService';
    }
}
