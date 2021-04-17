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
        $client->request(Request::METHOD_GET, '/contact');

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
    public function it_is_display_form_error(string $name, string $email, string $content, string $error, string $field)
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/contact');

        $crawler = $client->submitForm('Envoyer',[
            'contact_form[name]' => $name,
            'contact_form[email]' => $email,
            'contact_form[content]' => $content
        ]);

        $this->assertSelectorTextContains(
            'ul li',
            $error,
            'L\'erreur ne s\'affiche pas pour le champ '.$field
        );
    }

    /**
     * @test
     */
    public function it_is_send()
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/contact');

        $crawler = $client->submitForm('Envoyer',[
            'contact_form[name]' => self::NAME,
            'contact_form[email]' => self::EMAIL,
            'contact_form[content]' => self::CONTENT
        ]);

        $this->assertResponseRedirects(
            '/contact',
            Response::HTTP_FOUND,
            'La page n\'a pas été redirigé après la soumission du form'
        );

        $client->followRedirect();

        $this->assertRouteSame('app_contact',[],'La route est différente');
        $this->assertSelectorTextContains(
            'div.alert-success',
            'Votre question a bien été envoyée',
            'Le sélecteur div.success ne contient pas le texte attendu'
        );
        $this->assertSelectorExists('form', 'Le formulaire est absent');
    }

    public function provideFields(): \Generator
    {
        yield['', self::EMAIL, self::CONTENT, 'Veuillez renseigner votre nom', 'name => blank'];
        yield['a', self::EMAIL, self::CONTENT, 'Votre nom doit contenir au moins deux lettres', 'name => min'];
        yield[
            str_repeat('max',6),
            self::EMAIL,
            self::CONTENT,
            'Votre nom ne peut pas contenir plus de 15 lettres',
            'name => max'
        ];
        yield[self::NAME, '', self::CONTENT, 'Veuillez renseigner votre email', 'email => blank'];
        yield[self::NAME, 'not an em@il', self::CONTENT, 'Veuillez renseigner un email valide', 'email => email'];
        yield[self::NAME, self::EMAIL, '', 'Veuillez nous indiquer votre question', 'content => blank'];
        yield[self::NAME, self::EMAIL, 'a', 'Veuillez être plus explicite concernant votre question', 'content => min'];
    }
}
