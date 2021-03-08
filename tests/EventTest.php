<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventTest extends WebTestCase
{
    public function testHome()
    {
        $client = static::createClient();
        $client->request("GET", "");
        // echo $client->getResponse();
        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request("GET", "/");
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testViewEvent()
    {
        $client = static::createClient();
        $client->request("GET", "/event");
        // echo $client->getResponse();
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testViewEventsList()
    {
        $client = static::createClient();
        $client->request("GET", "/events");
        // echo $client->getResponse();
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testEventCRUD()
    {
        $client = static::createClient();

        // test create
        $client->request("GET", "/event/create_event");
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}
