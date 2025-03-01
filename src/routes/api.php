<?php

/**
 * Route Mapping
 *
 * The system uses an associative array to map HTTP request routes to the controllers and methods that will handle them.
 * The format of the routes is as follows:
 * - Key: '[HTTP Method] [URL Path]' (e.g., 'GET /conta')
 * - Value: An array with two elements:
 *   1. The class name of the controller that will process the request.
 *   2. The method of the class that will be executed.
 *
 * Below are the routes defined for the application:
 *
 * @return array
 */
return [
    'GET /conta' => [\App\Http\Controllers\GetBankAccountController::class, 'handle'],
    'POST /conta' => [\App\Http\Controllers\CreateBankAccountController::class, 'handle'],
    'POST /transacao' => [\App\Http\Controllers\CreateTransactionController::class, 'handle'],
];
