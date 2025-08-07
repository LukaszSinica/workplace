<?php 
namespace App\Service;

use App\Entity\VacationRequest;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;

class VacationRequestCreate
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function vacationRequestCreate
    (
        int $userId, 
        string  $dateFrom, 
        string $dateTo, 
        string $reason
    ): Array
    {
        if (!$dateFrom || !$dateTo || !$reason) {
            return [
                'message' => 'Missing date or reason',
                'status' => 'error',
                "code" => 400,
            ];
        }

        $dateFrom = new DateTime($dateFrom);
        $dateTo = new DateTime($dateTo);

        if($dateFrom > $dateTo) {
            return [
                'message' => 'Invalid date range',
                'status' => 'error',
                'code' => 400
            ];
        }


        $vacationRequest = new VacationRequest();
        $vacationRequest->setUserId($userId); 
        $vacationRequest->setDateFrom($dateFrom);
        $vacationRequest->setDateTo($dateTo);
        $vacationRequest->setReason($reason);
        $this->entityManager->persist($vacationRequest);
        $this->entityManager->flush();


        $days = $dateFrom->diff($dateTo)->days + 1; 

        return [
            'message' => 'Vacation request created successfully',
            'status' => 'success',
            'code' => 200,
            'data' => [
                'id' => $vacationRequest->getId(),
                'user_id' => $userId,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'days' => $days,
                'reason' => $reason,
            ],
        ];
    }

}