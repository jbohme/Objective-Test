<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\BankAccount;

interface BankAccountRepositoryInterface
{
    public function findByAccountNumber(int $accountNumber): ?BankAccount;

    public function existsByAccountNumber(int $accountNumber): bool;

    public function save(BankAccount $bankAccount): void;

    public function update(BankAccount $bankAccount): void;
}
