<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\GetBankAccount\GetBankAccountInputDTO;
use App\Services\GetBankAccount\GetBankAccountOutputDTO;
use App\Services\GetBankAccount\GetBankAccountService;
use DomainException;
use Exception;
use TypeError;

readonly class GetBankAccountController
{
    use Response;
    public function __construct(
        private GetBankAccountService $service,
    ) {
    }

    public function handle(Request $request): void
    {
        try {
            $account = $this->service->execute(new GetBankAccountInputDTO((int) $request->get('numero_conta')));
            $this->json(201, $this->dataMapper($account));
        } catch (DomainException $exception) {
            $this->json(404);
        } catch (Exception|TypeError $exception) {
            $this->json(500);
        }
    }


    /**
     * @param GetBankAccountOutputDTO $outputDTO
     * @return array<string,mixed>
     */
    private function dataMapper(GetBankAccountOutputDTO $outputDTO): array
    {
        return [
            'numero_conta' => $outputDTO->getAccountNumber(),
            'saldo' => $outputDTO->getBalance(),
        ];
    }
}
