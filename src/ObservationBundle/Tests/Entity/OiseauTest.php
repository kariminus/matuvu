<?php

namespace ObservationBundle\Tests\Entity;

use ObservationBundle\Entity\Oiseau;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OiseauTest extends WebTestCase
{

    public function testOiseau()
    {
        $oiseau = new Oiseau();
        $oiseau->setId(1234);
        $oiseau->setScientificName('Gavia arctica');
        $oiseau->setName('Plongeon arctique');
        $oiseau->setOrdre('Gaviiformes');
        $oiseau->setFamily('Gaviidae');
        $oiseau->setSlug('gavia-arctica');

        $this->assertEquals(1234, $oiseau->getId());
        $this->assertEquals('Gavia arctica', $oiseau->getScientificName());
        $this->assertEquals('Plongeon arctique', $oiseau->getName());
        $this->assertEquals('Gaviiformes', $oiseau->getOrdre());
        $this->assertEquals('Gaviidae', $oiseau->getFamily());
        $this->assertEquals('gavia-arctica', $oiseau->getSlug());
    }
}