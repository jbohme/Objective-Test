<?php

namespace App\Services\CreateTransaction;

class CreateTransactionOutputDTO
{
    public function __construct(
        protected int $accountNumber,
        protected float $balance,
    ) {
    }

    public function getAccountNumber(): int
    {
        return $this->accountNumber;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }
}
