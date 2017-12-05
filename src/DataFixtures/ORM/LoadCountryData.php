<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Intl\Intl;

class LoadCountryData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $countriesInfo = Intl::getRegionBundle()->getCountryNames('en');

        foreach ($countriesInfo as $countryCode => $countryName) {
            $country = new Country($countryCode, $countryName);
            $manager->persist($country);
        }

        $manager->flush();
    }
}
