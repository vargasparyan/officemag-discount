<?php

namespace App\Controller;

use App\Entity\Discount;
use App\Form\UserDiscountForm;
use App\Repository\UserRepository;
use App\Service\UserDiscountService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;
use DateTimeImmutable;

#[Route('/discount')]
final class DiscountController extends AbstractController
{
    #[Route('/view/{userId}', name: 'discount_view')]
    public function view(UserRepository $userRepository, Environment $twig, int $userId): Response
    {
        $user     = $userRepository->find($userId);
        $discount = $user->getLastDiscount();
        if (null === $discount || $discount->getCreatedAt() < new DateTimeImmutable('-3 hour')) {
            $discount = new Discount();
        }

        return new Response(
            $twig->render('discount_view.html.twig', [
                'form' =>  $this->createForm(UserDiscountForm::class, $discount)->createView(),
                'user' =>  $user,
                'discount' =>  $discount,
            ])
        );
    }

    #[Route('/generate-code/{userId}', name: 'discount_generate_code')]
    public function generateCode(UserDiscountService $userDiscountService, int $userId): JsonResponse
    {
        return $this->json(
            $userDiscountService->getUserDiscountGeneratedData($userId)
        );
    }

    #[Route('/check-code/{userId}', name: 'discount_check_code')]
    public function checkCode(UserDiscountService $userDiscountService, int $userId, Request $request): JsonResponse
    {
        return $this->json(
            $userDiscountService->getUserDiscountCodeCheckingData(
                $userId,
                $request->query->get('code') ?: null
            )
        );
    }
}
