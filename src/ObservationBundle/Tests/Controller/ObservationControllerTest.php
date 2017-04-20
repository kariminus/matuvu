<?php

namespace ObservationBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
<<<<<<< HEAD
=======
use Symfony\Component\HttpFoundation\File\UploadedFile;
>>>>>>> karim

class ObservationControllerTest extends WebTestCase
{
    public function testView()
    {
<<<<<<< HEAD

=======
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/login');
        $formLogin = $crawler->filter('button')->form();
        $formLogin['login_form[_username]'] = 'karim.meciel@gmail.com';
        $formLogin['login_form[_password]'] = '1234';
        $client->submit($formLogin);

        $crawler = $client->request('GET', '/profil/observation/50');

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
>>>>>>> karim
    }

    public function testAdd()
    {
<<<<<<< HEAD
=======
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/login');
        $formLogin = $crawler->filter('button')->form();
        $formLogin['login_form[_username]'] = 'karim.meciel@gmail.com';
        $formLogin['login_form[_password]'] = '1234';
        $client->submit($formLogin);

        $crawler = $client->request('GET', '/oiseau/gavia-septentrionalis/add');

        $form = $crawler->filter('button')->form();
        $file = new UploadedFile('C:\Users\karim\Desktop\290px-Linotte_melodieuse.jpg', 'linotte_melodieuse');

        $form['observation[date][day]']->select(14);
        $form['observation[date][month]']->select(04);
        $form['observation[date][year]']->select(2017);
        $form['observation[latitude]'] = 48.8473075;
        $form['observation[longitude]'] = 2.2875811000000112;
        $form['observation[imageFile]'] = $file;
        $client->submit($form);
        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
>>>>>>> karim

    }

    public function testDelete()
    {
<<<<<<< HEAD

=======
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/login');
        $formLogin = $crawler->filter('button')->form();
        $formLogin['login_form[_username]'] = 'karim.meciel@gmail.com';
        $formLogin['login_form[_password]'] = '1234';
        $client->submit($formLogin);

        $crawler = $client->request('GET', '/profil/observation/50');

        $link = $crawler->selectLink('Refuser')->link();

        $client->click($link);

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
>>>>>>> karim
    }

    public function testImageDelete()
    {
<<<<<<< HEAD
=======
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/login');
        $formLogin = $crawler->filter('button')->form();
        $formLogin['login_form[_username]'] = 'karim.meciel@gmail.com';
        $formLogin['login_form[_password]'] = '1234';
        $client->submit($formLogin);

        $crawler = $client->request('GET', '/profil/observation/33');

        $link = $crawler->selectLink('Supprimer l\'image')->link();

        $client->click($link);

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
>>>>>>> karim

    }

    public function testValidate()
    {
<<<<<<< HEAD

=======
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/login');
        $formLogin = $crawler->filter('button')->form();
        $formLogin['login_form[_username]'] = 'karim.meciel@gmail.com';
        $formLogin['login_form[_password]'] = '1234';
        $client->submit($formLogin);

        $crawler = $client->request('GET', '/profil/observation/33');

        $link = $crawler->selectLink('Valider')->link();

        $client->click($link);

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
>>>>>>> karim
    }
}