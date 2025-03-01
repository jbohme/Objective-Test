<?php

namespace App\Http\Controllers;

use App\Entities\Enums\PaymentMethods;
use App\Http\Request;
use App\Http\Response;
use App\Services\CreateTransaction\CreateTransactionInputDTO;
use App\Services\CreateTransaction\CreateTransactionOutputDTO;
use App\Services\CreateTransaction\CreateTransactionService;

class CreateTransactionController
{
    use Response;
    public function __construct(
        private CreateTransactionService $service,
    ) {
    }

    public function handle(Request $request): void
    {
        try {
            $account = $this->service->execute(
                new CreateTransactionInputDTO(
                    accountNumber: $request->get('numero_conta'),
                    amount:  $request->get('valor'),
                    paymentMethod:  PaymentMethods::tryFrom($request->get('forma_pagamento')),
                )
            );
            $this->json(201, $this->dataMapper($account));
        } catch (\DomainException $exception) {
            $this->json(404);
        } catch (\Exception|\TypeError $exception) {
            $this->json(500);
        }
    }

    private function dataMapper(CreateTransactionOutputDTO $outputDTO): array
    {
        return [
            'numero_conta' => $outputDTO->getAccountNumber(),
            'saldo' => $outputDTO->getBalance(),
        ];
    }

}
