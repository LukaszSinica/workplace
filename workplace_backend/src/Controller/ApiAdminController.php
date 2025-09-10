<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;



class ApiAdminController extends AbstractController
{

    public function __construct(
    )
    {
    }

    #[Route('/api/admin/user/create', name: 'api_admin_create_user', methods: ['POST'])]
    public function createUser(
        EntityManagerInterface $entityManager, 
        Request $request, 
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;
        $firstName = $data['firstName'] ?? null;
        $secondName = $data['secondName'] ?? null;
        $birthday = $data['birthday'] ?? null;
        $password = $data['password'] ?? null;
        $role = ['ROLE_USER'];

        if (!$email || !$firstName || !$secondName || !$birthday || !$password) {
            return $this->json([
                'message' => 'All fields are required',
                'status' => 'error',
            ], 400);
        }

        $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($existingUser) {
            return $this->json([
                'message' => 'User with this email already exists',
                'status' => 'error',
            ], 400);
        }

        $user = new User();
        $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setSecondName($secondName);
        $user->setBirthday(new \DateTime($birthday));

        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $password
        );

        $user->setPassword($hashedPassword);
        $user->setRoles($role);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json([
            'message' => 'User created successfully',
            'status' => 'success',
            'user_id' => $user->getId(),
        ]);
    }

}
