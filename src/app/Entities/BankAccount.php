<?php

declare(strict_types=1);

namespace App\Entities;

use DomainException;

class BankAccount
{
    public function __construct(
        private readonly int    $accountNumber,
        private float $balance = 0
    ) {
        $this->validateNegativeBalance();
    }

    private function validateNegativeBalance(): void
    {
        if ($this->balance < 0) {
            throw new DomainException("Balance cannot be negative.");
        }
    }

    public function withdrawAmount(float $amount): void
    {
        if ($this->balance < $amount) {
            throw new DomainException("Insufficient balance for this operation");
        }
        $this->balance -= $amount;
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
