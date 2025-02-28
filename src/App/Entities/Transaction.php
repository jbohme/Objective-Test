<?php
declare(strict_types=1);

namespace App\Entities;

class Transaction
{
    protected float $amountWithFee;

    public function __construct(
        protected string $id,
        protected string $paymentMethod,
        protected int $accountNumber,
        protected float $originalAmount,
        protected float $feeAmount,
        protected float $finalAmount
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    public function getAccountNumber(): int
    {
        return $this->accountNumber;
    }

    public function getOriginalAmount(): float
    {
        return $this->originalAmount;
    }

    public function getFeeAmount(): float
    {
        return $this->feeAmount;
    }

    public function getFinalAmount(): float
    {
        return $this->finalAmount;
    }
}