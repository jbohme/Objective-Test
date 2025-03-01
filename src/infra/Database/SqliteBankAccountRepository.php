<?php

//declare(strict_types=1);

namespace Infra\Database;

use App\Entities\BankAccount;
use App\Repositories\BankAccountRepositoryInterface;
use PDO;

class SqliteBankAccountRepository implements BankAccountRepositoryInterface
{
    public function existsByAccountNumber(int $accountNumber): bool
    {
        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM bank_accounts WHERE account_number = :account_number');
        $stmt->execute(['account_number' => $accountNumber]);

        return (bool) $stmt->fetchColumn();
    }

    public function save(BankAccount $bankAccount): void
    {
        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare('INSERT INTO bank_accounts (account_number, balance) VALUES (:account_number, :balance)');
        $stmt->execute([
            'account_number' => $bankAccount->getAccountNumber(),
            'balance' => $bankAccount->getBalance(),
        ]);
    }

    public function findByAccountNumber(int $accountNumber): ?BankAccount
    {
        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare('SELECT account_number, balance FROM bank_accounts WHERE account_number = :account_number');
        $stmt->execute(['account_number' => $accountNumber]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!is_array($row)) {
            return null;
        }

        return new BankAccount(
            $row['account_number'],
            $row['balance']
        );
    }

    public function update(BankAccount $bankAccount): void
    {
        $pdo = Connection::getConnection();
        $stmt = $pdo->prepare('UPDATE bank_accounts SET balance = :balance WHERE account_number = :account_number');
        $stmt->execute([
            'account_number' => $bankAccount->getAccountNumber(),
            'balance' => $bankAccount->getBalance(),
        ]);
    }
}
