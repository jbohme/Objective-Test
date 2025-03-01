<?php

namespace App\Http\Controllers;

use App\Entities\Enums\PaymentMethods;
use App\Http\Request;
use App\Http\Response;
use App\Services\CreateTransaction\CreateTransactionInputDTO;
use App\Services\CreateTransaction\CreateTransactionOutputDTO;
use App\Services\CreateTransaction\CreateTransactionService;
use Exception;
use TypeError;
use DomainException;

class CreateTransactionController
{
    use Response;
    public function __construct(
        private readonly CreateTransactionService $service,
    ) {
    }

    public function handle(Request $request): void
    {
        try {
            $account = $this->service->execute(
                new CreateTransactionInputDTO(
                    accountNumber: (int) $request->get('numero_conta'),
                    amount:  (float) $request->get('valor'),
                    paymentMethod:  PaymentMethods::from((string) $request->get('forma_pagamento')),
                )
            );
            $this->json(201, $this->dataMapper($account));
        } catch (DomainException $exception) {
            $this->json(404);
        } catch (Exception|TypeError $exception) {
            $this->json(500);
        }
    }

    /**
     * @param CreateTransactionOutputDTO $outputDTO
     * @return array<string,mixed>
     */
    private function dataMapper(CreateTransactionOutputDTO $outputDTO): array
    {
        return [
            'numero_conta' => $outputDTO->getAccountNumber(),
            'saldo' => $outputDTO->getBalance(),
        ];
    }

}
