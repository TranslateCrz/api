<?php

namespace App\Controller;

use App\Application\Service\AccountService;
use App\View\AccountPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    protected AccountService $accountService;
    protected AccountPresenter $presenter;

    public function __construct(AccountService $accountService, AccountPresenter $presenter)
    {
        $this->accountService = $accountService;
        $this->presenter = $presenter;
    }

    #[Route('/', methods: ['GET'])]
    public function index(): Response
    {
        return $this->json([
            'status' => true
        ]);
    }

    #[Route('/admin/account', methods: ['GET'])]
    public function getAccounts(): Response
    {
        return $this->json($this->presenter->presentAccounts($this->accountService->getAll()));
    }

    #[Route('/admin/account/{id}', methods: ['DELETE'])]
    public function deleteAccount(string $id): Response
    {
        return $this->json($this->accountService->delete($id));
    }
}
