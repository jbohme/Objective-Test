<?php

namespace Tests\Unit\Services;

use App\Entities\BankAccount;
use App\Repositories\BankAccountRepositoryInterface;
use App\Services\GetBankAccount\GetBankAccountService;
use App\Services\GetBankAccount\GetBankAccountInputDTO;
use App\Services\GetBankAccount\GetBankAccountOutputDTO;
use DomainException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class GetBankAccountServiceTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testShouldReturnAccountIfExists(): void
    {
        $bankAccountEntity = new BankAccount(accountNumber: 1, balance: 478.90);
        $input = new GetBankAccountInputDTO($bankAccountEntity->getAccountNumber());

        $bankAccountRepository = $this->createMock(BankAccountRepositoryInterface::class);
        $bankAccountRepository->method('findByAccountNumber')
            ->with($input->getAccountNumber())
            ->willReturn($bankAccountEntity);

        $service = new GetBankAccountService($bankAccountRepository);
        $result = $service->execute($input);

        $this->assertInstanceOf(GetBankAccountOutputDTO::class, $result);
        $this->assertEquals(478.90, $result->getBalance());
    }

    /**
     * @throws Exception
     */
    public function testShouldThrowExceptionIfAccountNotFound(): void
    {
        $input = new GetBankAccountInputDTO(1);

        $bankAccountRepository = $this->createMock(BankAccountRepositoryInterface::class);
        $bankAccountRepository->method('findByAccountNumber')
            ->with($input->getAccountNumber())
            ->willReturn(null);

        $service = new GetBankAccountService($bankAccountRepository);

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('The bank account could not be found.');

        $service->execute($input);
    }
}
