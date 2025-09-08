<?php

namespace App\Controller;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;


class ApiProfileController extends AbstractController
{
    public function __construct(
    )
    {
    }

    #[Route('/api/profile', name: 'api_get_user_data', methods: ['GET'])]
    public function getUserData(#[CurrentUser] ?User $user): JsonResponse
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        
        if (!$user) {
            throw $this->createNotFoundException('User not found');
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