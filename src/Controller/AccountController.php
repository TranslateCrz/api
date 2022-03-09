<?php

namespace App\Controller;

use App\Application\Dto\RegisterDto;
use App\Application\Service\AccountService;
use App\View\AccountPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    protected AccountService $accountService;
    protected AccountPresenter $presenter;

    public function __construct(AccountService $accountService, AccountPresenter $presenter)
    {
        $this->accountService = $accountService;
        $this->presenter = $presenter;
    }

    #[Route('/register', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $dto = new RegisterDto();
        $body = $request->toArray();
        $dto->email = $body['email'] ?? null;
        $dto->countries = $body['countries'] ?? [];
        $dto->company = $body['company'] ?? null;
        return $this->json($this->presenter->presentAccount($this->accountService->create($dto)));
    }

    #[Route('/login', methods: ['POST'])]
    public function login(Request $request): Response
    {
        if (!$user = $this->accountService->getByEmail($request->toArray()['email'] ?? '')) {
            throw $this->createAccessDeniedException();
        }
        return $this->json(['token' => $user->getEmail()]);
    }

    #[Route('/profile', methods: ['GET'])]
    public function getMe(): Response
    {
        if (!$user = $this->accountService->get()) {
            $this->createNotFoundException();
        }
        return $this->json($this->presenter->presentAccount($user));
    }

    #[Route('/profile', methods: ['PUT'])]
    public function updateMe(Request $request): Response
    {
        $dto = new RegisterDto();
        $body = $request->toArray();
        $dto->countries = $body['countries'] ?? [];
        $dto->company = $body['company'] ?? null;

        if (!$user = $this->accountService->update(null, $dto)) {
            $this->createNotFoundException();
        }
        return $this->json($this->presenter->presentAccount($user));
    }
}
