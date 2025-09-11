<?php

namespace App\Tests\Request;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminCreateUserTest extends WebTestCase
{

    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    public function testAdminCreateUser(): void
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
            'POST',
            '/api/admin/user/create',
            [],
            [],
            [
                'HTTP_AUTHORIZATION' => sprintf('Bearer %s', $token),
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode([
                "email" => "test@email.com", 
                "firstName" => "Test", 
                "secondName" => "User", 
                "birthday" => "1990-01-01", 
                "password" => "testpassword"
            ])
        );

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());

        $adminCreateUserRequest = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('user_id', $adminCreateUserRequest);
        $this->assertNotEmpty($adminCreateUserRequest['user_id']);      
    }
}