<?php
namespace App\Services;

use Cart;

class TaxService
{
    protected $taxRate = 0.2;

    public function calculate()
    {
        
        return (float) str_replace(',', '', Cart::subtotal()) * $this->taxRate;
    }
    public function totalAmount()
    {
        $subtotal = (float) str_replace(',', '', Cart::subtotal());
        return $subtotal + $this->calculate();
    }

    public function setTaxRate($rate)
    {
        $this->taxRate = $rate;
    }

    
}
