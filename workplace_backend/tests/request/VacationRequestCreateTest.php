<?php
namespace App\Tests\Service;

use App\Service\VacationRequestCreate;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\VacationRequest;
use Doctrine\ORM\EntityManagerInterface;


class VacationRequestCreateTest extends KernelTestCase
{
    public function testVacationRequestCreate(): void 
    {
        self::bootKernel();
        $mockEntityManager = $this->createMock(EntityManagerInterface::class);
        $vacationRequest = $this->createMock(VacationRequest::class);
        $vacationRequest->method('getId')->willReturn(123);
        $mockEntityManager->expects($this->once())
        ->method('persist')
        ->with($this->isInstanceOf(VacationRequest::class));

        $mockEntityManager->expects($this->once())
            ->method('flush');

        $vacationRequestCreate = new VacationRequestCreate($mockEntityManager);

        $result = $vacationRequestCreate->vacationRequestCreate(
            1,
            '2023-12-01',
            '2023-12-10',
            'Annual leave'
        );

        $this->assertEquals('Vacation request created successfully', $result['message']);
        $this->assertEquals('success', $result['status']);
        $this->assertEquals(200, $result['code']);
        $this->assertEquals(10, $result['data']['days']);
        $this->assertEquals('Annual leave', $result['data']['reason']);
    }

    public function testInvalidDateRange(): void 
    {
        $mockEntityManager = $this->createMock(EntityManagerInterface::class);
        $vacationRequestCreate = new VacationRequestCreate($mockEntityManager);

        $result = $vacationRequestCreate->vacationRequestCreate(
            1,
            '2023-12-10',
            '2023-12-01',
            'Annual leave'
        );

        $this->assertEquals('Invalid date range', $result['message']);
        $this->assertEquals('error', $result['status']);
        $this->assertEquals(400, $result['code']);
    }

    public function testMissingData(): void 
    {
        $mockEntityManager = $this->createMock(EntityManagerInterface::class);
        $service = new VacationRequestCreate($mockEntityManager);

        $result = $service->vacationRequestCreate(
            1,
            '',
            '2023-12-10',
            ''
        );

        $this->assertEquals('Missing date or reason', $result['message']);
        $this->assertEquals('error', $result['status']);
        $this->assertEquals(400, $result['code']);
    }
}