<?php

namespace App\DataFixtures;

use App\Entity\Job;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class JobFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Tableau des choses à ajouter
        $tab = array(
            array('title' => 'Support'),
            array('title' => 'Designer-web'),
            array('title' => 'Graphiste'),
            array('title' => 'Developpeur'),
            array('title' => 'Commercial'),
        );
        foreach ($tab as $row) {
            // On crée la country
            $Job = new Job();
            $Job->setTitle($row['title']);
            $manager->persist($Job);
        }
        // On déclenche l'enregistrement
        $manager->flush();
    }
}
