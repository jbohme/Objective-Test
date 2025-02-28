<?php

namespace App\Services\GetBankAccount;

use App\Repositories\BankAccountRepositoryInterface;

class GetBankAccountService
{
    public function __construct(
        private BankAccountRepositoryInterface $bankAccountRepository
    )
    {
    }

    public function execute(GetBankAccountInputDTO $inputDTO): GetBankAccountOutputDTO
    {
        $bankAccount = $this->bankAccountRepository->findByAccountNumber($inputDTO->getAccountNumber());

        if (is_null($bankAccount)) {
            throw new \DomainException("The bank account could not be found.");
        }
        return new GetBankAccountOutputDTO(accountNumber: $bankAccount->getAccountNumber(), balance: $bankAccount->getBalance());
    }
}