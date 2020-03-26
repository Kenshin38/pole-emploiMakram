<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Employee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class EmployeeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++) {
            $employee = new Employee();
            $employee->setFirstname($faker->firstname);
            $employee->setLastname($faker->lastname);
            $employee->setEmployementDate($faker->dateTime());

            $manager->persist($employee);
        }

        $manager->flush();
    }
}
