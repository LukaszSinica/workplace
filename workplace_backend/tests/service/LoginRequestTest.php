<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginRequestTest extends WebTestCase
{

    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    public function testLoginRequest(): void
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

        $this->assertResponseHasCookie("AUTH_TOKEN");
    }

    public function testLogoutRequest(): void
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
            '/api/logout',
            [],
            [],
            [
                'HTTP_AUTHORIZATION' => sprintf('Bearer %s', $token),
            ]
        );

        $cookie = $client->getResponse()->headers->getCookies()[0];
        $this->assertSame('AUTH_TOKEN', $cookie->getName());
        $this->assertSame('', $cookie->getValue());
        $this->assertNotNull($cookie->getExpiresTime()); 

    }
}
