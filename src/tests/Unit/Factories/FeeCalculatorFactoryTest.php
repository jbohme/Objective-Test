<?php

namespace Tests\Unit\Factories;

use App\Entities\CreditCardFeeCalculator;
use App\Entities\DebitCardFeeCalculator;
use App\Entities\Enums\PaymentMethods;
use App\Entities\PIXFeeCalculator;
use App\Factories\FeeCalculatorFactory;
use PHPUnit\Framework\TestCase;

class FeeCalculatorFactoryTest extends TestCase
{
    public function testShouldCreateCreditCardFee(): void
    {
        $factory = new FeeCalculatorFactory();
        $feeCalculator = $factory->create(PaymentMethods::CREDIT_CARD);

        $this->assertInstanceOf(CreditCardFeeCalculator::class, $feeCalculator);
    }

    public function testShouldCreateDebitCardFee(): void
    {
        $factory = new FeeCalculatorFactory();
        $feeCalculator = $factory->create(PaymentMethods::DEBIT_CARD);

        $this->assertInstanceOf(DebitCardFeeCalculator::class, $feeCalculator);
    }

    public function testShouldCreatePixFee(): void
    {
        $factory = new FeeCalculatorFactory();
        $feeCalculator = $factory->create(PaymentMethods::PIX);

        $this->assertInstanceOf(PIXFeeCalculator::class, $feeCalculator);
    }
}
