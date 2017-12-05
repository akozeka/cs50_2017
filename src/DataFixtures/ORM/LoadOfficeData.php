<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\OfficeCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadOfficeData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $officeCategoriesInfo = [
            'CS' => 'Consulting',
            'HR' => 'Human Resources',
            'SM' => 'Social Media Marketing',
            'SE' => 'Software Engineering',
            'WD' => 'Web Development',
        ];

        foreach ($officeCategoriesInfo as $officeCategoryCode => $officeCategoryName) {
            $officeCategory = new OfficeCategory();
            $officeCategory->setCode($officeCategoryCode);
            $officeCategory->setName($officeCategoryName);
            $manager->persist($officeCategory);
        }

        $manager->flush();
    }
}
