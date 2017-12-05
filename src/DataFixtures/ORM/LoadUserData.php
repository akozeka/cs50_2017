<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\PostAddressEmbeddable;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User(
            'akozeka@gmail.com',
            'Alex',
            'Kozeka',
            'male',
            new \DateTime('1979-12-02'),
            $this->container->get('app.registration_handler')->encodePassword('qqqqqq'),
            User::ROLE_ADMIN,
            User::ENABLED,
            new PostAddressEmbeddable('UA', 'Mariupol', 'Morskoy blvd., 50/18', '87541'),
            null
        );
        $manager->persist($user);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [LoadCountryData::class];
    }
}
