<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use App\Controller\EventController;
use App\Entity\Event;

use DateInterval;

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

    public function testAddNewEvent()
    {
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request("GET", "/event/add_event");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton("Submit")->form();

        $form["event[title]"]->setValue("Unit Test title");
        $form["event[description]"]->setValue("Unit Test description");
        $form["event[location]"]->setValue("Unit Test location");
        $form["event[priority]"]->setValue("*****");
        $startDateTime = new \DateTime('@'.strtotime('now'));
        $endDateTime   = new \DateTime('@'.strtotime('now'));
        $endDateTime->add(new DateInterval('P10D'));
        $form["event[start_time]"]->setValue($startDateTime->format('Y-m-d'));
        $form["event[end_time]"]->setValue($endDateTime->format('Y-m-d'));

        $crawler = $client->submit($form);
        $this->assertContains("UNDER CONSTRUCTION", $client->getResponse()->getContent());
    }
}
