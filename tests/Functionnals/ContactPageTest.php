<?php
declare(strict_types=1);

namespace App\Tests\Functionnals;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactPageTest extends WebTestCase
{
    const NAME = 'user';
    const EMAIL = 'user@example.com';
    const CONTENT = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

    /**
     * @test
     */
    public function it_is_accessible(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK, 'La page n\'est pas accessible');
        $this->assertSelectorTextContains(
            'h1',
            'Faites nous part de votre question',
            'Le sélecteur h1 ne contient pas le texte attendu'
        );
        $this->assertSelectorExists('form', 'Le formulaire est absent');
    }

    //TODO Accessible pour l'administrateur

    /**
     * @test
     * @dataProvider provideFields
     */
    public function it_is_display_form_blank_error(string $name, string $email, string $content, string $error, string $field)
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/');

        $crawler = $client->submitForm('Envoyer',[
            'contact_form[name]' => $name,
            'contact_form[email]' => $email,
            'contact_form[content]' => $content
        ]);

        $this->assertSelectorTextContains(
            'ul li', $error,
            'L\'erreur ne s\'affiche pas pour le champ '.$field
        );
    }

    public function provideFields(): \Generator
    {
        yield['', self::EMAIL, self::CONTENT, 'Veuillez renseigner votre nom', 'name'];
        yield[self::NAME, '', self::CONTENT, 'Veuillez renseigner votre email', 'email'];
        yield[self::NAME, self::EMAIL, '', 'Veuillez nous indiquer votre question', 'content'];
    }
}
