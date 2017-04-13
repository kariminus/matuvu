<?php

namespace ObservationBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use ObservationBundle\Entity\EspeceProtegee;

class LoadEspeceProtegee extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {

        if (($handle = fopen(dirname(__FILE__).'/Resources/especes.csv', 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 4000, ";")) !== FALSE) {
                $espece = new EspeceProtegee();
                $espece->setId($data[0]);
                $espece->setClasse($data[1]);
                $manager->persist($espece);
                $manager->flush();

            }
            fclose($handle);

        }
    }
}