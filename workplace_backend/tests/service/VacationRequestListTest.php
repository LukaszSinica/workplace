<?php
namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VacationRequestListTest extends WebTestCase
{

    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    public function testVacationRequestList(): void
    {
        $client = static::createClient();

        $username = $_ENV['APP_TEST_USER'];
        $password = $_ENV['APP_TEST_PASSWORD'];

        $client->request(
            'POST',
            '/api/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => $username,
                'password' => $password
            ])
        );

        $this->assertResponseIsSuccessful();

        $cookie = $client->getCookieJar()->get('AUTH_TOKEN');
        $this->assertNotNull($cookie, 'AUTH_TOKEN cookie was not set on login response');

        $token = $cookie->getValue();
        $this->assertNotEmpty($token, 'AUTH_TOKEN cookie has no value');

        $client->request(
            'GET',
            '/api/vacation_request/list',
            [],
            [],
            [
                'HTTP_AUTHORIZATION' => sprintf('Bearer %s', $token),
                'CONTENT_TYPE' => 'application/json',
            ]
        );

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());

        $vacationRequests = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('vacation_requests', $vacationRequests);
        $this->assertIsArray($vacationRequests['vacation_requests']);
    }
}