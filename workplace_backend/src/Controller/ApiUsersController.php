<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;


final class ApiUsersController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private Security $security,
    )
    {
    }

    #[Route('/api/users', name: 'api_users')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to the API Users endpoint!',
            'status' => 'success',
        ]);
    }

    #[Route('/api/user/password-change', name: 'api_user_password_change', methods: ['POST'])]
    public function changePassword(#[CurrentUser] ?User $user, EntityManagerInterface $entityManager,  UserPasswordHasherInterface $passwordHasher, Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }
        $data = json_decode($request->getContent(), true);
        $password = $data['password'] ?? null;

        if (!$password) {
            return $this->json([
                'message' => 'Password is required',
                'status' => 'error',
            ], 400);
        }
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $password
        );

        $user->setPassword($hashedPassword);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json([
            'message' => 'Password changed successfully',
            'status' => 'success',
        ]);
    }

    #[Route('/api/user/password-reset', name: 'api_user_password_reset', methods: ['POST'])]
    public function resetPassword(
        EntityManagerInterface $entityManager,  
        UserPasswordHasherInterface $passwordHasher, 
        Request $request, 
        MailerInterface $mailer
    ): JsonResponse {

        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;
        $password = bin2hex(random_bytes(10));

        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email ?? null]);
        if (!$user) {
            return $this->json([
                'message' => 'User not found',
                'status' => 'error',
            ], 404);
        }


        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $password
        );

        $user->setPassword($hashedPassword);
        $entityManager->persist($user);
        $entityManager->flush();

        $message = (new Email())
        ->from('no-reply@example.com')
        ->to($user->getEmail())
        ->subject('Your new password')
        ->text("Hello, your new password is: $password");

        $mailer->send($message);

        return $this->json([
            'message' => 'Password reset successfully',
            'status' => 'success',
        ]);
    }
}