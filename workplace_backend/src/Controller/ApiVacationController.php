<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use App\Service\VacationRequestCreate;


final class ApiVacationController extends AbstractController
{

    public function __construct(
        private RequestStack $requestStack,
        private Security $security,
        private VacationRequestCreate $vacationRequestCreate,
    )
    {
    }

    #[Route('/api/vacation', name: 'api_vacation')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to the API Vacation endpoint!',
            'status' => 'success',
        ]);
    }


    #[Route('/api/vacation_request/create', name: 'api_vacation_request_create', methods: ['POST'])]
    public function vacation_requert(VacationRequestCreate $vacationRequestCreate, EntityManagerInterface $entityManager, Request $request): JsonResponse
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
        $data = json_decode($request->getContent(), true);

        $vacationRequest = $vacationRequestCreate->vacationRequestCreate(
            $user->getId(),
            $data['date_from'] ?? null,
            $data['date_to'] ?? null,
            $data['reason'] ?? null, 
        );
        
        if($vacationRequest["code"] !== 200) {
            return $this->json([
                'message' => $vacationRequest["message"],
                'status' => 'error',
            ], $vacationRequest["code"]);
        }

        return $this->json([
            'message' => 'vacation request added successfully',
            'vacation_request' => [
                'id' => $vacationRequest["data"]['id'],
                'date_from' => $vacationRequest["data"]['date_from'],
                'date_to' => $vacationRequest["data"]['date_to'],
                'reason' => $vacationRequest["data"]['reason'],
                'user_id' => $vacationRequest["data"]['user_id'],
                'days' => $vacationRequest["data"]['days'],
            ],
        ], 200);
    }
}
