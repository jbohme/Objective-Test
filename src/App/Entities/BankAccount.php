<?php
declare(strict_types=1);

namespace App\Entities;

class BankAccount
{
    public function __construct(
        private readonly int   $accountNumber,
        private readonly float $balance = 0
    )
    {
        $this->validateNegativeBalance();
    }

    public function validateNegativeBalance(): void
    {
        if ($this->balance < 0) {
            throw new \InvalidArgumentException("Balance cannot be negative.");
        }
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