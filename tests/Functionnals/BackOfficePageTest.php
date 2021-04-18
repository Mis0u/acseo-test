<?php

namespace App\Tests\Functionnals;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BackOfficePageTest extends WebTestCase
{
    const EMAIL = 'admin@example.com';

    /**
     * @test
     */
    public function it_is_not_accessible(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/admin');

        $this->assertResponseRedirects(
            '/connexion',
            Response::HTTP_FOUND,
            'La redirection n\'a pas eu lieu'
        );

        $client->followRedirect();

        $this->assertSelectorTextContains('h1','Page de connexion','Le h1 ne contient pas le texte souhaité');
    }

    /**
     * @test
     */
    public function it_is_accessible(): void
    {
        $client = static::createClient();

        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail(self::EMAIL);

        $client->loginUser($testUser);

        $client->request(Request::METHOD_GET, '/admin');

        $this->assertResponseIsSuccessful('La page n\'a pas été renvoyé');

        $this->assertSelectorTextContains('h1','Back office','Le h1 ne contient pas le texte souhaité');
    }
}
