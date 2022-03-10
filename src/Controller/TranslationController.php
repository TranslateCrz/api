<?php

namespace App\Controller;

use App\Application\Dto\TranslationDto;
use App\Application\Service\TranslationService;
use App\View\TranslationPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TranslationController extends AbstractController
{
    protected TranslationService $translationService;
    protected TranslationPresenter $translationPresenter;

    public function __construct(TranslationService $translationService, TranslationPresenter $translationPresenter)
    {
        $this->translationService = $translationService;
        $this->translationPresenter = $translationPresenter;
    }

    #[Route('/translation', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $dto = new TranslationDto();
        $body = $request->toArray();
        $dto->code = $body['code'] ?? null;
        $dto->country = $body['country'] ?? null;
        $dto->value = $body['value'] ?? null;
        return $this->json($this->translationPresenter->presentTranslation($this->translationService->create($dto)));
    }

    #[Route('/translation/{id}', methods: ['GET'])]
    public function get(string $id): Response
    {
        return $this->json($this->translationPresenter->presentTranslation($this->translationService->get($id)));
    }

    #[Route('/translation', methods: ['GET'])]
    public function getAll(): Response
    {
        return $this->json($this->translationPresenter->presentTranslations($this->translationService->getAll()));
    }

    #[Route('/translation/codes', methods: ['POST'])]
    public function addCodes(Request $request): Response
    {
        $this->translationService->createCodes($request->toArray());
        return $this->json(['success' => true, 'codes' => count($request->toArray())]);
    }

    #[Route('/translation/{id}', methods: ['PUT'])]
    public function update(string $id, Request $request): Response
    {
        $dto = new TranslationDto();
        $dto->value = $request->toArray()['value'] ?? null;
        return $this->json($this->translationPresenter->presentTranslation($this->translationService->update($id, $dto)));
    }

    #[Route('/translation/{id}', methods: ['DELETE'])]
    public function delete(string $id): Response
    {
        return $this->json($this->translationService->delete($id));
    }
}
