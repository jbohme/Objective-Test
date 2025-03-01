<?php

namespace App\Services\CreateBankAccount;

use App\Entities\BankAccount;
use App\Repositories\BankAccountRepositoryInterface;

class CreateBankAccountService
{
    public function __construct(
        private BankAccountRepositoryInterface $bankAccountRepository
    ) {
    }

    public function execute(CreateBankAccountInputDTO $inputDTO): CreateBankAccountOutputDTO
    {
        if ($this->bankAccountRepository->existsByAccountNumber($inputDTO->getAccountNumber())) {
            throw new \DomainException("Account already exists.");
        }
        $bankAccount = new BankAccount(
            accountNumber: $inputDTO->getAccountNumber(),
            balance: $inputDTO->getBalance()
        );

        $this->bankAccountRepository->save($bankAccount);

        return new CreateBankAccountOutputDTO($bankAccount->getAccountNumber(), $bankAccount->getBalance());
    }
}
