<?php

namespace App\DataFixtures;

use App\Entity\ContactRequest;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @codeCoverageIgnore
 */
class AppFixtures extends Fixture
{
    const EMAIL = 'admin@example.com';
    const PASSWORD = 'pass_1234';

    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setEmail(self::EMAIL)
             ->setRoles(['ROLE_ADMIN'])
             ->setPassword($this->encoder->encodePassword($user,self::PASSWORD));

        $manager->persist($user);

        for ($i = 1; $i <= 5; $i++){
            $requestContact = new ContactRequest();

            $requestContact->setEmail('user'.$i.'@example.com')
                           ->setName('user'.$i)
                           ->setContent(str_repeat('lorem ipsum', 10));

            $manager->persist($requestContact);
        }


        $manager->flush();
    }
}
