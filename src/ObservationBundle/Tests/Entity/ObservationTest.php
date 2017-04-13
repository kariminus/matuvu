<?php

namespace ObservationBundle\Tests\Entity;

use ObservationBundle\Entity\Observation;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ObservationTest extends WebTestCase
{
    public function testObservation()
    {
        $observation = new Observation();
        $observation->setId(1);
        $observation->setDate(new \DateTime());
        $observation->setLatitude(123456789);
        $observation->setLongitude(987654321);
        $observation->setValidated(1);

        $this->assertEquals(1, $observation->getId());
        $this->assertEquals(new \DateTime(), $observation->getDate());
        $this->assertEquals(123456789, $observation->getLatitude());
        $this->assertEquals(987654321, $observation->getLongitude());
        $this->assertEquals(true, $observation->isValidated());
    }
}