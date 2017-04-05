<?php

namespace ObservationBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use ObservationBundle\Entity\Observation;
use ObservationBundle\Entity\Oiseau;

class LoadOiseau extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {

        if (($handle = fopen(dirname(__FILE__).'/Resources/TAXREF.csv', 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 4000, ";")) !== FALSE) {
                $oiseau = new Oiseau();
                $oiseau->setId($data[2]);
                $oiseau->setScientificName(mb_convert_encoding($data[3], 'UTF-8', 'ISO-8859-1'));
                $oiseau->setName(mb_convert_encoding($data[4], 'UTF-8', 'ISO-8859-1'));
                $oiseau->setOrdre($data[0]);
                $oiseau->setFamily($data[1]);
                $manager->persist($oiseau);
                $manager->flush();

            }
            fclose($handle);

        }
    }
}