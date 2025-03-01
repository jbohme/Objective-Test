<?php
declare(strict_types=1);

namespace App\Entities;

class DebitCardFeeCalculator implements FeeCalculatorInterface
{
    public function calcule(float $amount): float
    {
        return $amount * 0.03;
    }
}