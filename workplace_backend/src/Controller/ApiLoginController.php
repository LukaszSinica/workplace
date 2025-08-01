<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Entity\User;
use Symfony\Component\HttpFoundation\RequestStack;

class ApiLoginController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
    )
    {
        
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]    
    public function index(#[CurrentUser] ?User $user): Response
    {

        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $token = "token";
        $session = $this->requestStack->getSession();
        return $this->json([
            'user'  => $user->getUserIdentifier(),
            'token' => $token,
            'message' => 'login successsssful',
            'session_id' => $session->getId(),
        ]);
    }
}