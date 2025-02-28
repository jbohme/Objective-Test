<?php

namespace App\Services\CreateTransaction;

use App\Entities\Enums\PaymentMethods;

class CreateTransactionInputDTO
{
    public function __construct(
        protected int $accountNumber,
        protected float $amount,
        protected PaymentMethods $paymentMethod,
    )
    {
    }

    public function getAccountNumber(): int
    {
        return $this->accountNumber;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getPaymentMethod(): PaymentMethods
    {
        return $this->paymentMethod;
    }
}