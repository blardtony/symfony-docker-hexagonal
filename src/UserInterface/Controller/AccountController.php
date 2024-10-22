<?php

namespace App\UserInterface\Controller;

use App\Application\Service\AccountService;
use App\UserInterface\DTO\AccountDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class AccountController extends AbstractController
{

    public function __construct(
      private readonly AccountService $accountService
    ) {
    }

    #[Route('/accounts', name: 'get_accounts', methods: ['GET'])]
    public function getAccounts(): JsonResponse
    {
        $accounts = $this->accountService->getAllAccounts();
        return new JsonResponse(array_map(fn($account) => AccountDTO::fromEntity($account), $accounts));
    }

    #[Route('/accounts', name: 'create_account', methods: ['POST'])]
    public function createAccount(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $accountNumber = $data['account_number'];
        $account = $this->accountService->createAccount($accountNumber);
        return new JsonResponse(AccountDTO::fromEntity($account), 201);
    }
}