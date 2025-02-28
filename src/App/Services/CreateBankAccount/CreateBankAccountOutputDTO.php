<?php

namespace App\Services\CreateBankAccount;
class CreateBankAccountOutputDTO
{
    public function __construct(
        protected int $accountNumber,
        protected float $balance,
    )
    {
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