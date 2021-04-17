<?php
declare(strict_types=1);

namespace App\Tests\Units;

use App\Entity\ContactRequest;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    const NAME = 'user';
    const EMAIL = 'user@example.com';
    const CONTENT = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

    /**
     * @test
     */
    public function it_return_true(): void
    {
        $request = new ContactRequest();

        $request->setName(self::NAME)
                ->setEmail(self::EMAIL)
                ->setContent(self::CONTENT)
                ->setIsRequestFinished(true);

        $this->assertTrue($request->getName() === self::NAME, 'GetName est différent du Setter');
        $this->assertTrue($request->getEmail() === self::EMAIL, 'GetEmail est différent du Setter');
        $this->assertTrue($request->getContent() === self::CONTENT, 'GetContent est différent du Setter');
        $this->assertTrue($request->getIsRequestFinished(), 'getIsRequestFinished est différent du Setter');
    }

    /**
     * @test
     */
    public function it_return_false(): void
    {
        $request = new ContactRequest();

        $request->setName(self::NAME)
                ->setEmail(self::EMAIL)
                ->setContent(self::CONTENT)
                ->setIsRequestFinished(false);

        $this->assertFalse($request->getName() !== self::NAME, 'GetName est différent du Setter');
        $this->assertFalse($request->getEmail() !== self::EMAIL, 'GetEmail est différent du Setter');
        $this->assertFalse($request->getContent() !== self::CONTENT, 'GetContent est différent du Setter');
        $this->assertFalse($request->getIsRequestFinished(), 'getIsRequestFinished est différent du Setter');
    }

    /**
     * @test
     */
    public function it_return_empty(): void
    {
        $request = new ContactRequest();

        $request->setName('')
            ->setEmail('')
            ->setContent('')
            ->setIsRequestFinished(false);

        $this->assertEmpty($request->getName(), 'GetName contient une valeur');
        $this->assertEmpty($request->getEmail(), 'GetEmail contient une valeur');
        $this->assertEmpty($request->getContent(), 'GetContent contient une valeur');
        $this->assertEmpty($request->getIsRequestFinished(), 'getIsRequestFinished contient une valeur');
    }

    /**
     * @test
     */
    public function it_is_string(): void
    {
        $request = new ContactRequest();

        $request->setName(self::NAME)
            ->setEmail(self::EMAIL)
            ->setContent(self::CONTENT);

        $this->assertIsString($request->getName(), 'GetName ne renvoie pas une valeur de type string');
        $this->assertIsString($request->getEmail(), 'GetEmail ne renvoie pas une valeur de type string');
        $this->assertIsString($request->getContent(), 'GetContent ne renvoie pas une valeur de type string');
    }

    /**
     * @test
     */
    public function it_is_bool(): void
    {
        $request = new ContactRequest();

        $request->setIsRequestFinished(true);

        $this->assertIsBool($request->getIsRequestFinished(), 'getIsRequestFinished ne renvoie pas une valeur de type bool');
    }
}
