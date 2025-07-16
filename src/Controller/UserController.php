<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

#[Route('/user')]
final class UserController extends AbstractController
{
    #[Route('/list', name: 'user_list')]
    public function index(UserRepository $userRepository, Environment $twig): Response
    {
        return new Response(
            $twig->render('user_list.html.twig', [
                'users' => $userRepository->findAll(),
            ])
        );
    }
}
