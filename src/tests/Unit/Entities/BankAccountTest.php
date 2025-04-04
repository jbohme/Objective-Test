<?php

declare(strict_types=1);

namespace Tests\Unit\Entities;

use App\Entities\BankAccount;
use DomainException;
use PHPUnit\Framework\TestCase;
use TypeError;

class BankAccountTest extends TestCase
{
    public function testCreateBankAccount(): void
    {
        $bankAccount = new BankAccount(
            accountNumber: 1
        );

        $this->assertEquals(1, $bankAccount->getAccountNumber());
        $this->assertEquals(0, $bankAccount->getBalance());
    }

    public function testIfBankAccountValidationThrowsExceptionWithNegativeBalance(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage("Balance cannot be negative.");

        new BankAccount(
            accountNumber: 1,
            balance: -2.50
        );
    }

    public function testIfBankAccountValidationThrowsExceptionWithBalanceOfADifferentTypeThanFloat(): void
    {
        $this->expectException(TypeError::class);

        new BankAccount(
            accountNumber: 1,
            balance: "2.50"
        );
    }

    public function testShouldThrowExceptionIfThereIsNotEnoughBalanceInTheAccount(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage("Insufficient balance for this operation");

        $bankAccount = new BankAccount(
            accountNumber: 1,
            balance: 10.50
        );

        $bankAccount->withdrawAmount(11.00);
    }

    public function testShouldWithdrawAnAmount(): void
    {
        $bankAccount = new BankAccount(
            accountNumber: 1,
            balance: 10.50
        );

        $bankAccount->withdrawAmount(10.00);

        $this->assertEquals(0.50, $bankAccount->getBalance());
    }
}
