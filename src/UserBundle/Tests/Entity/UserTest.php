<?php

namespace UserBundle\Tests\Entity;

use UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{

    public function testUser()
    {
        $user = new User();
        $user->setId(10);
        $user->setFirstName('Michel');
        $user->setLastName('Dupont');
        $user->setEmail('michel.dupont@mail.com');
        $user->setPlainPassword('123456789');
        $user->setPostalCode(75005);

        $this->assertEquals(10, $user->getId());
        $this->assertEquals('Michel', $user->getFirstName());
        $this->assertEquals('Dupont', $user->getLastName());
        $this->assertEquals('michel.dupont@mail.com', $user->getEMail());
        $this->assertEquals('123456789', $user->getPlainPassword());
        $this->assertEquals(75005, $user->getPostalCode());
    }
}