<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Entity\User;
use App\Entity\Timer;

class ApiTimerController extends AbstractController
{
    public function __construct(
    )
    {
    }


    #[Route('/api/timer/start', name: 'api_timer_start', methods: ['POST'])]
    public function startTimer(#[CurrentUser] ?User $user, EntityManagerInterface $entityManager): JsonResponse
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $timer = new Timer();
        $timer->setUserId($user->getId());
        $timer->setStart(new \DateTime());
        $entityManager->persist($timer);
        $entityManager->flush();

        return $this->json([
            "timer_id" => $timer->getId(),
            'message' => 'Timer started',
            'status' => 'success',
        ]);
    }

    #[Route('/api/timer/stop', name: 'api_timer_stop', methods: ['POST'])]
    public function stopTimer(#[CurrentUser] ?User $user, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }
        $data = json_decode($request->getContent(), true);
        $timerId = $data['timer_id'] ?? null;

        if (!$timerId) {
            return $this->json([
                'message' => 'Timer ID is required',
                'status' => 'error',
            ], 400);
        }
        $timerRepository = $entityManager->getRepository(Timer::class);

        $timer = $timerRepository->find($timerId);
        
        if (!$timer || $timer->getUserId() !== $user->getId()) {
            return $this->json([
                'message' => 'Timer not found',
                'status' => 'error',
            ], 404);
        }
    
        $timer->setStop(new \DateTime());
        $timer->setHours(($timer->getStop()->getTimestamp() - $timer->getStart()->getTimestamp()) / 3600);
        $entityManager->persist($timer);
        $entityManager->flush();

        return $this->json([
            'message' => 'Timer stopped',
            'status' => 'success',
        ]);
    }
}