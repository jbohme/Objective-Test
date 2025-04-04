<?php

namespace App\Services\CreateTransaction;

use App\Entities\Transaction;
use App\Factories\FeeCalculatorFactory;
use App\Repositories\BankAccountRepositoryInterface;
use App\Repositories\TransactionRepositoryInterface;
use DomainException;

readonly class CreateTransactionService
{
    public function __construct(
        private BankAccountRepositoryInterface $bankAccountRepository,
        private TransactionRepositoryInterface $transactionRepository,
        private FeeCalculatorFactory           $feeCalculatorFactory,
    ) {
    }

    public function execute(CreateTransactionInputDTO $inputDTO): CreateTransactionOutputDTO
    {
        $bankAccount = $this->bankAccountRepository->findByAccountNumber($inputDTO->getAccountNumber());
        if (is_null($bankAccount)) {
            throw new DomainException('Bank Account not found');
        }

        $feeCalculator = $this->feeCalculatorFactory->create($inputDTO->getPaymentMethod());
        $feeAmount = $feeCalculator->calcule($inputDTO->getAmount());
        $finalAmount = $inputDTO->getAmount() + $feeAmount;

        $bankAccount->withdrawAmount($finalAmount);

        $transaction = new Transaction(
            id: uniqid(),
            paymentMethod: $inputDTO->getPaymentMethod()->name,
            accountNumber: $inputDTO->getAccountNumber(),
            originalAmount: $inputDTO->getAmount(),
            feeAmount: $feeAmount,
            finalAmount: $finalAmount
        );

        $this->bankAccountRepository->update($bankAccount);
        $this->transactionRepository->save($transaction);

        return new CreateTransactionOutputDTO(
            accountNumber: $bankAccount->getAccountNumber(),
            balance: $bankAccount->getBalance()
        );
    }
}
