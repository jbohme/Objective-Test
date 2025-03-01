<?php

namespace App\Entities;

interface FeeCalculatorInterface
{
    public function calcule(float $amount): float;
}