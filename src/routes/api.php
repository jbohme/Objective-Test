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

use App\Http\Controllers\CreateBankAccountController;
use App\Http\Controllers\CreateTransactionController;
use App\Http\Controllers\GetBankAccountController;

return [
    'GET /conta' => [GetBankAccountController::class, 'handle'],
    'POST /conta' => [CreateBankAccountController::class, 'handle'],
    'POST /transacao' => [CreateTransactionController::class, 'handle'],
];
