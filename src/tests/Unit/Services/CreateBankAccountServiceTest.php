<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Repositories\BankAccountRepositoryInterface;
use App\Services\CreateBankAccount\CreateBankAccountService;
use App\Services\CreateBankAccount\CreateBankAccountInputDTO;
use App\Services\CreateBankAccount\CreateBankAccountOutputDTO;
use PHPUnit\Framework\TestCase;

class CreateBankAccountServiceTest extends TestCase
{
    public function testShouldCreateAccountIfItDoesNotExist()
    {
        $input = new CreateBankAccountInputDTO(accountNumber: 1, balance: 150.00);

        $bankAccountRepository = $this->createMock(BankAccountRepositoryInterface::class);
        $bankAccountRepository->method('save');

        $service = new CreateBankAccountService($bankAccountRepository);
        $output = $service->execute($input);

        $this->assertInstanceOf(CreateBankAccountOutputDTO::class, $output);
        $this->assertEquals(1, $output->getAccountNumber());
        $this->assertEquals(150, $output->getBalance());
    }

    public function testShouldThrowExceptionIfAccountAlreadyExists()
    {
        $input = new CreateBankAccountInputDTO(accountNumber: 1, balance: 150.00);

        $bankAccountRepository = $this->createMock(BankAccountRepositoryInterface::class);
        $bankAccountRepository->expects($this->once())
            ->method('existsByAccountNumber')
            ->with($input->getAccountNumber())
            ->willReturn(true);

        $bankAccountRepository->expects($this->never())->method('save');

        $service = new CreateBankAccountService($bankAccountRepository);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("Account already exists.");

        $service->execute($input);
    }
}
