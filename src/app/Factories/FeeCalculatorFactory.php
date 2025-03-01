<?php

namespace App\Factories;

use App\Entities\CreditCardFeeCalculator;
use App\Entities\DebitCardFeeCalculator;
use App\Entities\Enums\PaymentMethods;
use App\Entities\FeeCalculatorInterface;
use App\Entities\PIXFeeCalculator;

class FeeCalculatorFactory
{
    public function create(PaymentMethods $method): FeeCalculatorInterface
    {
        return match ($method) {
            PaymentMethods::CREDIT_CARD => new CreditCardFeeCalculator(),
            PaymentMethods::DEBIT_CARD => new DebitCardFeeCalculator(),
            PaymentMethods::PIX => new PIXFeeCalculator(),
        };
    }
}
