<?php

use App\Repositories\BankAccountRepositoryInterface;
use App\Repositories\TransactionRepositoryInterface;
use DI\ContainerBuilder;
use Infra\Database\Repositories\SqliteBankAccountRepository;
use Infra\Database\Repositories\SqliteTransactionRepository;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        BankAccountRepositoryInterface::class => DI\autowire(SqliteBankAccountRepository::class),
        TransactionRepositoryInterface::class => DI\autowire(SqliteTransactionRepository::class),
    ]);
};
