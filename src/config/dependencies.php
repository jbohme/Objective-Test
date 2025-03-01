<?php

use App\Repositories\TransactionRepositoryInterface;
use DI\ContainerBuilder;
use App\Repositories\BankAccountRepositoryInterface;
use Infra\Database\SqliteBankAccountRepository;
use Infra\Database\SqliteTransactionRepository;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        BankAccountRepositoryInterface::class => DI\autowire(SqliteBankAccountRepository::class),
        TransactionRepositoryInterface::class => DI\autowire(SqliteTransactionRepository::class),
    ]);
};
