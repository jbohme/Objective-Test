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
    public function testShouldCreateCreditCardFee()
    {
        $factory = new FeeCalculatorFactory();
        $feeCalculator = $factory->create(PaymentMethods::C);

        $this->assertInstanceOf(CreditCardFeeCalculator::class, $feeCalculator);
    }

    public function testShouldCreateDebitCardFee()
    {
        $factory = new FeeCalculatorFactory();
        $feeCalculator = $factory->create(PaymentMethods::D);

        $this->assertInstanceOf(DebitCardFeeCalculator::class, $feeCalculator);
    }

    public function testShouldCreatePixFee()
    {
        $factory = new FeeCalculatorFactory();
        $feeCalculator = $factory->create(PaymentMethods::P);

        $this->assertInstanceOf(PIXFeeCalculator::class, $feeCalculator);
    }
}
