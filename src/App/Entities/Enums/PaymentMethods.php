<?php

namespace App\Entities\Enums;

enum PaymentMethods: string
{
    case P = "PIX";
    case C = "CREDIT_CARD";
    case D = "DEBIT_CARD";
}
