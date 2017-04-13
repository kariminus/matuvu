<?php

namespace ObservationBundle\Tests\Entity;

use ObservationBundle\Entity\EspeceProtegee;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class especeProtegeeTest extends WebTestCase
{
    public function testEspeceProtegee()
    {
        $espece = new EspeceProtegee();
        $espece->setId(1);
        $espece->setClasse('Aves');

        $this->assertEquals(1, $espece->getId());
        $this->assertEquals('Aves', $espece->getClasse());
    }
}