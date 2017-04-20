<?php

namespace UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testRegister()
    {
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $client->request('GET', '/register');
        $form = $crawler->filter('button')->form();

        $form['user_registration_form[firstName]'] = 'register';
        $form['user_registration_form[lastName]'] = 'register';
        $form['user_registration_form[email][first]'] = 'register@mail.com';
        $form['user_registration_form[email][second]'] = 'register@mail.com';
        $form['user_registration_form[plainPassword][first]'] = 'test';
        $form['user_registration_form[plainPassword][second]'] = 'test';
        $form['user_registration_form[postalCode]'] = 75000;

        $client->submit($form);

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testResetPassword()
    {
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $client->request('GET', '/resetting');

        $form = $crawler->filter('button')->form();

        $form['email'] = 'register@mail.com';

        $client->submit($form);

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testAdd()
    {
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/login');
        $formLogin = $crawler->filter('button')->form();
        $formLogin['login_form[_username]'] = 'admin@mail.com';
        $formLogin['login_form[_password]'] = 'admin';
        $client->submit($formLogin);

        $crawler = $client->request('GET', '/admin/user/ajouter');

        $form = $crawler->filter('button')->form();

        $form['registration[firstName]'] = 'test';
        $form['registration[lastName]'] = 'test';
        $form['registration[email]'] = 'test@mail.com';
        $form['registration[plainPassword]'] = 'test';
        $form['registration[postalCode]'] = 75000;
        $form['registration[roles]']->select('ROLE_PRO');

        $client->submit($form);

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testEdit()
    {
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/login');
        $formLogin = $crawler->filter('button')->form();
        $formLogin['login_form[_username]'] = 'admin@mail.com';
        $formLogin['login_form[_password]'] = 'admin';
        $client->submit($formLogin);

        $crawler = $client->request('GET', '/admin/user/25/modifier/');

        $form = $crawler->filter('button')->form();

        $form['registration[firstName]'] = 'test';
        $form['registration[lastName]'] = 'test';
        $form['registration[email]'] = 'edit@mail.com';
        $form['registration[plainPassword]'] = 'test';
        $form['registration[postalCode]'] = 75000;
        $form['registration[roles]']->select('ROLE_PRO');

        $client->submit($form);

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testDelete()
    {
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/login');
        $formLogin = $crawler->filter('button')->form();
        $formLogin['login_form[_username]'] = 'admin@mail.com';
        $formLogin['login_form[_password]'] = 'admin';
        $client->submit($formLogin);

        $crawler = $client->request('GET', '/admin/user/25/modifier/');

        $link = $crawler->selectLink('Supprimer le membre')->link();

        $client->click($link);

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }
}