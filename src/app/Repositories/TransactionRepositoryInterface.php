<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Transaction;

interface TransactionRepositoryInterface
{
    public function save(Transaction $transaction): void;
}
