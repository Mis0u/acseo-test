<?php

namespace App\Tests\Functionnals;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginPageTest extends WebTestCase
{
    const WRONG_EMAIL = 'wrong@example.com';
    const GOOD_EMAIL = 'admin@example.com';
    const WRONG_PASSWORD = 'wrong_password';
    const GOOD_PASSWORD = 'pass_1234';

    /**
     * @test
     */
    public function it_is_accessible(): void
    {
        $client = static::createClient();
        $client->request('GET', '/connexion');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK, 'La page n\'est pas accessible');
        $this->assertSelectorTextContains(
            'h1',
            'Connexion',
            'Le sélecteur h1 ne contient pas le texte attendu'
        );
        $this->assertSelectorExists('form', 'Le formulaire est absent');
    }

    /**
     * @test
     */
    public function it_is_redirect(): void
    {
        $client = static::createClient();

        $userRepository = static::$container->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail(self::GOOD_EMAIL);

        $client->loginUser($testUser);

        $client->request(Request::METHOD_GET, '/connexion');

        $this->assertResponseRedirects(
            '/admin',
            Response::HTTP_FOUND,
            'La page de connexion a été affiché');
    }

    /**
     * @test
     * @dataProvider provideFields
     */
    public function it_is_display_form_error(string $email, string $password, string $error, string $field): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/connexion');

        $crawler = $client->submitForm('Connexion',[
            'email' => $email,
            'password' => $password,
        ]);

        $this->assertResponseRedirects(
            '/connexion',
            Response::HTTP_FOUND,
            'Le form contenait un email invalid est n\'a pas renvoyé vers la page connexion');

        $client->followRedirect();

        $this->assertSelectorTextContains(
            'div.alert.alert-danger',
            $error,
            'L\'erreur ne s\'affiche pas pour le champ '.$field
        );
    }

    /**
     * @test
     */
    public function it_is_logged()
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/connexion');

        $crawler = $client->submitForm('Connexion',[
            'email' => self::GOOD_EMAIL,
            'password' => self::GOOD_PASSWORD,
        ]);

        $this->assertResponseRedirects(
            '/admin',
            Response::HTTP_FOUND,
            'Le form n\'a pas renvoyé vers la page admin');

        $client->followRedirect();

        $this->assertRouteSame('app_admin',[],'La route est différente');

        $this->assertSelectorTextContains(
            'h1','Back office', 'Le sélecteur h1 ne contient pas le texte voulu '
        );
    }

    public function provideFields(): \Generator
    {
        yield[self::WRONG_EMAIL, self::GOOD_PASSWORD, 'Cet email est inconnu', 'email'];
        yield[self::WRONG_EMAIL, self::WRONG_PASSWORD, 'Cet email est inconnu', 'email'];
        yield[self::GOOD_EMAIL, self::WRONG_PASSWORD, 'Mot de passe incorrect', 'password'];
    }
}
