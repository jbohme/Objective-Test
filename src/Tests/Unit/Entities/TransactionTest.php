<?php
declare(strict_types=1);

namespace Tests\Unit\Entities;

use App\Entities\Enums\PaymentMethods;
use App\Entities\Transaction;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function testCreateTransaction(): void
    {
        $id = uniqid();
        $transaction = new Transaction(
            id: $id,
            paymentMethod: PaymentMethods::C->value,
            accountNumber: 1,
            originalAmount: 10.50,
            feeAmount: 0.5,
            finalAmount: 11.0,
        );

        $this->assertEquals($id, $transaction->getId());
        $this->assertEquals('CREDIT_CARD', $transaction->getPaymentMethod());
        $this->assertEquals(1, $transaction->getAccountNumber());
        $this->assertEquals(10.50, $transaction->getOriginalAmount());
        $this->assertEquals(0.5, $transaction->getFeeAmount());
        $this->assertEquals(11.0, $transaction->getFinalAmount());
    }
}
