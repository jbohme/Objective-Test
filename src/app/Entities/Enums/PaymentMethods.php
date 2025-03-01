<?php

namespace App\Entities\Enums;

enum PaymentMethods: string
{
    case PIX = "P";
    case CREDIT_CARD = "C";
    case DEBIT_CARD = "D";
}
