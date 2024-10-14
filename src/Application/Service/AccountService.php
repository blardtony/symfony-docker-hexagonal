<?php

namespace App\Application\Service;

use App\Domain\Entity\Account;
use App\Domain\Repository\AccountRepositoryInterface;

class AccountService
{
    public function __construct(
        private readonly AccountRepositoryInterface $accountRepository
    ) {
    }

    public function createAccount(string $accountNumber): Account
    {
        $account = new Account($accountNumber);
        $this->accountRepository->save($account);
        return $account;
    }

    public function deposit(int $accountId, float $amount): Account
    {
        $account = $this->accountRepository->findById($accountId);
        if (!$account) {
            throw new \InvalidArgumentException('Account not found');
        }
        $account->deposit($amount);
        $this->accountRepository->save($account);
        return $account;
    }
}