<?php

namespace PlatformBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlatformControllerTest extends WebTestCase
{
    public function testUserProfil()
    {
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/login');
        $formLogin = $crawler->filter('button')->form();
        $formLogin['login_form[_username]'] = 'karim.meciel@gmail.com';
        $formLogin['login_form[_password]'] = '1234';
        $client->submit($formLogin);

        $crawler = $client->request('GET', '/profil');

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testConditions()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/conditions');

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testUserPending()
    {
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/login');
        $formLogin = $crawler->filter('button')->form();
        $formLogin['login_form[_username]'] = 'karim.meciel@gmail.com';
        $formLogin['login_form[_password]'] = '1234';
        $client->submit($formLogin);

        $crawler = $client->request('GET', '/profil/pending');

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testProfilEdit()
    {
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/login');
        $formLogin = $crawler->filter('button')->form();
        $formLogin['login_form[_username]'] = 'karim.meciel@gmail.com';
        $formLogin['login_form[_password]'] = '1234';
        $client->submit($formLogin);

        $crawler = $client->request('GET', '/profil/modifier');

        $form = $crawler->filter('button')->form();

        $form['user_edit[firstName]'] = 'karim';
        $form['user_edit[lastName]'] = 'meciel';
        $form['user_edit[email]'] = 'karim.meciel@gmail.com';
        $form['user_edit[plainPassword]'] = '1234';
        $form['user_edit[postalCode]'] = 75000;

        $client->submit($form);

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testUserObservation()
    {
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/login');
        $formLogin = $crawler->filter('button')->form();
        $formLogin['login_form[_username]'] = 'karim.meciel@gmail.com';
        $formLogin['login_form[_password]'] = '1234';
        $client->submit($formLogin);

        $crawler = $client->request('GET', '/profil/observations');

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }
}