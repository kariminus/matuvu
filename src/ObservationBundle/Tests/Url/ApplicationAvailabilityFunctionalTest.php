<?php

namespace ObservationBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/login');
        $formLogin = $crawler->filter('button')->form();
        $formLogin['login_form[_username]'] = 'karim.meciel@gmail.com';
        $formLogin['login_form[_password]'] = '1234';
        $client->submit($formLogin);
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        return array(
            array('/'),
            array('/oiseau/gavia-septentrionalis'),
            array('/oiseau/gavia-septentrionalis/add'),
            array('/profil/observation/33'),
        );
    }
}