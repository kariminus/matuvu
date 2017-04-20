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
        $naturaliste = new User();

        $admin->setEmail('admin@mail.com');
        $admin->setFirstName('admin');
        $admin->setLastName('admin');
        $admin->setPostalcode(75015);
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPlainPassword("admin");
        $manager->persist($admin);

        $naturaliste->setEmail('naturaliste@mail.com');
        $naturaliste->setFirstName('naturaliste');
        $naturaliste->setLastName('naturaliste');
        $naturaliste->setPostalcode(75015);
        $naturaliste->setRoles(['ROLE_PRO']);
        $naturaliste->setPlainPassword("naturaliste");

        $manager->flush();
    }
}