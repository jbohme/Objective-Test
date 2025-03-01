<?php

declare(strict_types=1);

namespace App\Entities;

class PIXFeeCalculator implements FeeCalculatorInterface
{
    public function calcule(float $amount): float
    {
        return $amount * 0;
    }
}
