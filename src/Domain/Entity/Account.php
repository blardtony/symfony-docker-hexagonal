<?php
declare(strict_types=1);

namespace App\Domain\Entity;

class Account
{

    private int $id;
    private string $accountNumber;
    private float $balance;
    public function __construct(
        string $accountNumber,
        float $balance = 0.0,
    ) {
        $this->accountNumber = $accountNumber;
        $this->balance = $balance;
    }

    public function deposit(float $amount): void
    {
        $this->balance += $amount;
    }

    public function withdraw(float $amount): void
    {
        if ($amount > $this->balance) {
            throw new \InvalidArgumentException('Insufficient balance');
        }
        $this->balance -= $amount;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    public function setAccountNumber(string $accountNumber): void
    {
        $this->accountNumber = $accountNumber;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }
}