<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Cookie;

class ApiLoginController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
    )
    {
        
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        JWTTokenManagerInterface $jwtManager
    ): Response {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            return $this->json([
                'message' => 'Missing credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);

        if (!$user || !$passwordHasher->isPasswordValid($user, $password)) {
            return $this->json([
                'message' => 'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $jwtManager->create($user);

        $cookie = Cookie::create(
            name: 'AUTH_TOKEN',
            value: $token,
            expire: time() + 3600,
            path: '/',
            domain: null,
            secure: true,
            httpOnly: true,
            sameSite: 'Lax'
        );
    
        $response = $this->json([
            'message' => 'Login successful',
            'user'    => $user->getUserIdentifier(),
        ]);
    
        $response->headers->setCookie($cookie);
    
        return $response;
    }

    #[Route('/api/logout', name: 'api_logout', methods: ['POST'])]
    public function logout(): Response {

        $response = $this->json([
            'message' => 'Logged out successfully'
        ]);

        $response->headers->clearCookie(
            name: 'AUTH_TOKEN',
            path: '/',
            domain: null,
            secure: true,
            httpOnly: true,
            sameSite: 'Lax'
        );

        return $response;
    }
}