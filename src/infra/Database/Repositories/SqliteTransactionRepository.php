<?php

declare(strict_types=1);

namespace Infra\Database\Repositories;

use App\Entities\Transaction;
use App\Repositories\TransactionRepositoryInterface;
use Infra\Database\Connection;

class SqliteTransactionRepository implements TransactionRepositoryInterface
{
    public function save(Transaction $transaction): void
    {
        $pdo = Connection::getConnection();

        $stmt = $pdo->prepare('
            INSERT INTO transactions (
                id,
                payment_method,
                account_number,
                original_amount,
                fee_amount,
                final_amount,
                created_at
            ) VALUES (
                :id,
                :payment_method,
                :account_number,
                :original_amount,
                :fee_amount,
                :final_amount,
                :created_at
            )
        ');

        $stmt->execute([
            'id' => $transaction->getId(),
            'payment_method' => $transaction->getPaymentMethod(),
            'account_number' => $transaction->getAccountNumber(),
            'original_amount' => $transaction->getOriginalAmount(),
            'fee_amount' => $transaction->getFeeAmount(),
            'final_amount' => $transaction->getFinalAmount(),
            'created_at' => $transaction->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
    }
}
