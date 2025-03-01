<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\CreateBankAccount\CreateBankAccountInputDTO;
use App\Services\CreateBankAccount\CreateBankAccountOutputDTO;
use App\Services\CreateBankAccount\CreateBankAccountService;
use DomainException;
use Exception;
use Infra\Logger\Logger;
use InvalidArgumentException;
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
            $request->validate($this->rules());
            $account = $this->service->execute(
                new CreateBankAccountInputDTO(
                    accountNumber: (int) $request->get('numero_conta'),
                    balance:  (float) $request->get('saldo'),
                )
            );
            $this->json(201, $this->dataMapper($account));
        } catch (DomainException $exception) {
            $this->json(409, ['message' => $exception->getMessage()]);
        } catch (InvalidArgumentException $exception) {
            $this->json(422, ['message' => $exception->getMessage()]);
        } catch (Exception|TypeError $exception) {
            $this->json(500, ['message' => 'Internal Server Error']);
            Logger::error($exception->getMessage(), $exception);
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

    /**
     * @return string[]
     */
    private function rules(): array
    {
        return [
            'numero_conta' => 'integer',
            'saldo' => 'float',
        ];
    }
}
