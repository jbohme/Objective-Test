<?php

namespace App\Http\Controllers;

use App\Entities\Enums\PaymentMethods;
use App\Http\Request;
use App\Http\Response;
use App\Services\CreateTransaction\CreateTransactionInputDTO;
use App\Services\CreateTransaction\CreateTransactionOutputDTO;
use App\Services\CreateTransaction\CreateTransactionService;
use Exception;
use Infra\Logger\Logger;
use InvalidArgumentException;
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
            $request->validate($this->rules());
            $account = $this->service->execute(
                new CreateTransactionInputDTO(
                    accountNumber: (int) $request->get('numero_conta'),
                    amount:  (float) $request->get('valor'),
                    paymentMethod:  PaymentMethods::from((string) $request->get('forma_pagamento')),
                )
            );
            $this->json(201, $this->dataMapper($account));
        } catch (DomainException $exception) {
            $this->json(404, ['message' => $exception->getMessage()]);
        } catch (InvalidArgumentException $exception) {
            $this->json(422, ['message' => $exception->getMessage()]);
        } catch (Exception|TypeError $exception) {
            $this->json(500, ['message' => 'Internal Server Error']);
            Logger::error($exception->getMessage(), $exception);
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

    /**
     * @return string[]
     */
    private function rules(): array
    {
        return [
            'numero_conta' => 'integer',
            'valor' => 'float',
            'forma_pagamento' => 'string'
        ];
    }
}
