<?php

namespace App\Services\GetBankAccount;
class GetBankAccountInputDTO
{
    public function __construct(
        protected int $accountNumber,
    )
    {
    }

    public function getAccountNumber(): int
    {
        return $this->accountNumber;
    }
}