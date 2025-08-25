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
use App\Entity\VacationRequest;
use Symfony\Component\Security\Http\Attribute\CurrentUser;


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
    public function vacation_requert(#[CurrentUser] ?User $user, VacationRequestCreate $vacationRequestCreate, Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
   
        if (!$user) {
            throw $this->createNotFoundException('User not found');
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

    #[Route('/api/vacation_request/list', name: 'api_vacation_request_list', methods: ['GET'])]
    public function vacationRequestListForUser(#[CurrentUser] ?User $user, EntityManagerInterface $entityManager): JsonResponse
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $vacationRequestRepository = $entityManager->getRepository(VacationRequest::class);
        $vacationRequests = $vacationRequestRepository->findBy(['user_id' => $user->getId()]);
        

        return $this->json([
            'message' => 'Vacation requests retrieved successfully',
            'vacation_requests' => array_map(function ($request) {
                return [
                    'id' => $request->getId(),
                    'date_from' => $request->getDateFrom()->format('Y-m-d'),
                    'date_to' => $request->getDateTo()->format('Y-m-d'),
                    'reason' => $request->getReason(),
                ];
            }, $vacationRequests),
        ], 200);
       
    }

}
