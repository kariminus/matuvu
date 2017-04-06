<?php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\User;

class Loaduser extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $admin = new User();

        $admin->setEmail('admin@mail.com');
        $admin->setFirstname('admin');
        $admin->setLastname('admin');
        $admin->setPostalcode(75015);
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPlainPassword("admin");

        $manager->persist($admin);
        $manager->flush();
    }
}