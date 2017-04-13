<?php

namespace ObservationBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OiseauControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $client->request('GET', '/');

        $form = $crawler->filter('button')->form();
        $form['search'] = 'Plongeon catmarin';

        $client->submit($form);

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testView()
    {
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $client->request('GET', '/oiseau/gavia-septentrionalis');

        $form = $crawler->filter('button')->form();
        $form['search'] = 'Épervier d\'Europe';

        $client->submit($form);

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }
}