<?php

namespace App\UserInterface\DTO;

use App\Domain\Entity\Account;

class AccountDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $accountNumber,
        public readonly float $balance
    ) {
    }

    public static function fromEntity(Account $account): AccountDTO
    {
        return new AccountDTO(
            $account->getId(),
            $account->getAccountNumber(),
            $account->getBalance()
        );
    }
}