<?php

namespace Tests\Unit\Services;

use App\Entities\FeeCalculatorInterface;
use PHPUnit\Framework\TestCase;
use App\Services\CreateTransaction\CreateTransactionService;
use App\Repositories\BankAccountRepositoryInterface;
use App\Repositories\TransactionRepositoryInterface;
use App\Factories\FeeCalculatorFactory;
use App\Entities\Enums\PaymentMethods;
use App\Entities\BankAccount;
use App\Services\CreateTransaction\CreateTransactionInputDTO;

class CreateTransactionServiceTest extends TestCase
{
    public function testShouldCreateTransaction()
    {
        $bankAccount = new BankAccount(accountNumber: 1, balance: 10.0);

        $bankAccountRepository = $this->createMock(BankAccountRepositoryInterface::class);
        $transactionRepository = $this->createMock(TransactionRepositoryInterface::class);

        $feeCalculator = $this->createMock(FeeCalculatorInterface::class);
        $feeCalculator->method('calcule')->willReturn(0.05);

        $feeCalculatorFactory = $this->createMock(FeeCalculatorFactory::class);
        $feeCalculatorFactory->method('create')->willReturn($feeCalculator);

        $bankAccountRepository->method('findByAccountNumber')->willReturn($bankAccount);

        $service = new CreateTransactionService(
            bankAccountRepository:  $bankAccountRepository,
            transactionRepository:  $transactionRepository,
            feeCalculatorFactory:   $feeCalculatorFactory
        );

        $inputDTO = new CreateTransactionInputDTO(
            accountNumber: 1,
            amount: 5.0,
            paymentMethod: PaymentMethods::CREDIT_CARD
        );

        $transactionRepository->expects($this->once())->method('save');

        $outputDTO = $service->execute($inputDTO);

        $this->assertEquals(4.95, $outputDTO->getBalance());
    }

    public function testShouldThrowExceptionIfAccountNotFound()
    {
        $bankAccount = new BankAccount(accountNumber: 1, balance: 10.0);

        $bankAccountRepository = $this->createMock(BankAccountRepositoryInterface::class);
        $transactionRepository = $this->createMock(TransactionRepositoryInterface::class);
        $mockFeeCalculatorFactory = $this->createMock(FeeCalculatorFactory::class);

        $bankAccountRepository->method('findByAccountNumber')->willReturn(null);

        $service = new CreateTransactionService(
            $bankAccountRepository,
            $transactionRepository,
            $mockFeeCalculatorFactory
        );

        $inputDTO = new CreateTransactionInputDTO($bankAccount->getAccountNumber(), 4.0, PaymentMethods::CREDIT_CARD);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Bank Account not found');

        $service->execute($inputDTO);
    }
}
