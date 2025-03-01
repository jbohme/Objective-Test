<?php

declare(strict_types=1);

namespace App\Entities;

class CreditCardFeeCalculator implements FeeCalculatorInterface
{
    public function calcule(float $amount): float
    {
        return $amount * 0.05;
    }
}
