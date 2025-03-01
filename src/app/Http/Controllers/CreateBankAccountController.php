<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\CreateBankAccount\CreateBankAccountInputDTO;
use App\Services\CreateBankAccount\CreateBankAccountOutputDTO;
use App\Services\CreateBankAccount\CreateBankAccountService;
use DomainException;
use Exception;
use TypeError;

class CreateBankAccountController
{
    use Response;
    public function __construct(
        private readonly CreateBankAccountService $service,
    ) {
    }

    public function handle(Request $request): void
    {
        try {
            $account = $this->service->execute(
                new CreateBankAccountInputDTO(
                    accountNumber: (int) $request->get('numero_conta'),
                    balance:  (float) $request->get('saldo'),
                )
            );
            $this->json(201, $this->dataMapper($account));
        } catch (DomainException $exception) {
            $this->json(409);
        } catch (Exception|TypeError $exception) {
            $this->json(500);
        }
    }

    /**
     * @param CreateBankAccountOutputDTO $outputDTO
     * @return array<string,mixed>
     */
    private function dataMapper(CreateBankAccountOutputDTO $outputDTO): array
    {
        return [
            'numero_conta' => $outputDTO->getAccountNumber(),
            'saldo' => $outputDTO->getBalance(),
        ];
    }
}
