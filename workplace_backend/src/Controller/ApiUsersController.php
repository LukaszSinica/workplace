<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\SecurityBundle\Security;

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

    #[Route('/api/user', name: 'api_get_user_data', methods: ['GET'])]
    public function getUserData(EntityManagerInterface $entityManager): JsonResponse
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        $userRepository = $entityManager->getRepository(User::class);
        $userIdentifier = $this->security->getUser()->getUserIdentifier();
        $user = $userRepository->findOneBy(['email' => $userIdentifier]);

        
        if (!$user) {
            return $this->json([
                'message' => 'User not found',
                'status' => 'error',
            ], 404);
        }

        return $this->json([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'secondName' => $user->getSecondName(),
            'birthday' => $user->getBirthday() ? $user->getBirthday()->format('Y-m-d') : null,
            'roles' => $user->getRoles(),
        ]);
    }

}