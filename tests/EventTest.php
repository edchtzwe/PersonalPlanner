<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventTest extends WebTestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }

    public function testHome()
    {
        $client = static::createClient();
        $client->request("GET", "");
        // echo $client->getResponse();
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testGetEventHome()
    {
        $client = static::createClient();
        $client->request("GET", "/event");
        // echo $client->getResponse();
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}
