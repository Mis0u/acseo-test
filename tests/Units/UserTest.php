<?php
declare(strict_types=1);

namespace App\Tests\Units;

use PHPUnit\Framework\TestCase;
use App\Entity\User;

class UserTest extends TestCase
{
    const EMAIL = "user@example.com";

    /**
     * @test
     */
    public function it_return_true(): void
    {
        $user = new User();

        $user->setEmail(self::EMAIL)
             ->setPassword('pass_1234')
             ->setRoles([])
        ;

        $this->assertTrue($user->getEmail() === self::EMAIL, 'GetEmail est différent du Setter');
        $this->assertTrue($user->getPassword() === 'pass_1234', 'GetPassword est différent du Setter');
        $this->assertTrue($user->getRoles() === ['ROLE_USER'], 'GetRoles est différent du Setter');
    }

    /**
     * @test
     */
    public function it_return_false(): void
    {
        $user = new User();

        $user->setEmail(self::EMAIL)
             ->setPassword('pass_1234')
             ->setRoles(['ROLE_USER'])
        ;

        $this->assertFalse($user->getEmail() !== self::EMAIL, 'GetEmail est identique au Setter');
        $this->assertFalse($user->getPassword() !== 'pass_1234', 'GetPassword est identique au Setter');
        $this->assertFalse($user->getRoles() !== ['ROLE_USER'], 'GetRoles est identique au Setter');

    }

    /**
     * @test
     */
    public function it_return_empty(): void
    {
        $user = new User();

        $user->setEmail('')
             ->setPassword('')
        ;
        //dd($user->getRoles());

        $this->assertEmpty($user->getEmail(), 'GetEmail contient une valeur');
        $this->assertEmpty($user->getPassword(), 'GetPassword contient une valeur');


    }

    /**
     * @test
     */
    public function it_is_string(): void
    {
        $user = new User();

        $user->setEmail(self::EMAIL)
             ->setPassword('pass_1234');

        $this->assertIsString($user->getEmail(), 'GetEmail ne renvoie pas une valeur de type string');
        $this->assertIsString($user->getPassword(), 'GetPassword ne renvoie pas une valeur de type string');
    }
}
