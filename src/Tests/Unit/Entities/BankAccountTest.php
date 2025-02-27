<?php
declare(strict_types=1);

namespace Tests\Unit\Entities;

use App\Entities\BankAccount;
use PHPUnit\Framework\TestCase;

class BankAccountTest extends TestCase
{
    public function testCreateBankAccount()
    {
        $bankAccount = new BankAccount(
            accountNumber: 1
        );

        $this->assertEquals(0, $bankAccount->getBalance());
    }

    public function testIfBankAccountValidationThrowsExceptionWithNegativeBalance()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Balance cannot be negative.");

        new BankAccount(
            accountNumber: 1,
            balance: -2.50
        );
    }

    public function testIfBankAccountValidationThrowsExceptionWithBalanceOfADifferentTypeThanFloat()
    {
        $this->expectException(\TypeError::class);

        new BankAccount(
            accountNumber: 1,
            balance: "2.50"
        );
    }
}
