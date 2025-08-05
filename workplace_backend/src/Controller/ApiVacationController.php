<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\VacationRequest;
use Symfony\Bundle\SecurityBundle\Security;
use DateTime;
use Symfony\Component\HttpFoundation\Request;

final class ApiVacationController extends AbstractController
{

    public function __construct(
        private RequestStack $requestStack,
        private Security $security,
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
    public function vacation_requert(EntityManagerInterface $entityManager, Request $request): JsonResponse
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

        if (!$data['date_from'] || !$data['date_to'] || !$data['reason']) {
            return $this->json([
                'message' => 'Missing date or reason',
                'status' => 'error',
            ], 400);
        }

        $dateFrom = new DateTime($data['date_from']);
        $dateTo = new DateTime($data['date_to']);

        if($dateFrom > $dateTo) {
            return $this->json([
                'message' => 'Invalid date range',
                'status' => 'error',
            ], 400);
        }
        $reason = $data['reason'] ?? null;

        $vacationRequest = new VacationRequest();
        $vacationRequest->setUserId($user->getId()); 
        $vacationRequest->setDateFrom($dateFrom);
        $vacationRequest->setDateTo($dateTo);
        $vacationRequest->setReason($reason);
        $entityManager->persist($vacationRequest);
        $entityManager->flush();

        return $this->json([
            'message' => 'vacation request added successfully',
            'vacation_request' => [
                'id' => $vacationRequest->getId(),
                'user_id' => $vacationRequest->getUserId(),
                'days' => ($dateTo->diff($dateFrom)->days + 1),
                'reason' => $vacationRequest->getReason(),
            ],
        ], 200);
    }
}
