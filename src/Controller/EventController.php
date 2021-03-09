<?php

namespace App\Controller;

// Controller is deprecated in 4.1, AbstractController is the way to go, so let's future proof ourselves
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;

use DateInterval;

class EventController extends AbstractController
{
    public function getRepository()
    {
        return $this->getDoctrine()
            ->getRepository(Event::class);
    }

    public function findOrError($event)
    {
        if (!$event) {
            throw $this->createNotFoundException("Coudln't find Event with id : ".$eventId);
        }
        return true;
    }

    public function createAction(): Response
    {
        // equivalent to adding an argument to this action like createAction(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $event = new Event();
        $event->setTitle("Title");
        $event->setDescription("Description Description");
        $event->setLocation("Location Location");
        $event->setPriority("**********");
        $event->setStartTime(new \DateTime('@'.strtotime('now')));
        $endDateTime = new \DateTime('@'.strtotime('now'));
        // period 10 days
        $endDateTime->add(new DateInterval('P10D'));
        $event->setEndTime($endDateTime);

        // tells Doctrine you want to eventually save the product (no queries yet)
        $entityManager->persist($event);

        // actually executes the queries
        $entityManager->flush();

        // we will wanna redirect to the view page after the add
        return new Response("Event saved with ID : ".$event->getId());
    }

    public function readAction($eventId)
    {
        $repository = $this->getRepository();
        $event = $repository->find($eventId);

        if ($this->findOrError($event)) {
            return new Response("Event with title : ".$event->getTitle()." found.");
        }
        return $event;
    }

    public function getAllAction()
    {
        $repository = $this->getRepository();
        $allEvents = $repository->findAll();
    }

    public function updateAction($eventId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $event = $this->readAction($eventId);

        if ($this->findOrError($event)) {
            return new Response("Event with title : ".$event->getTitle()." found.");
        }

        $event->setTitle("Updated Title");
        $entityManager->flush();

        return $this->redirectToRoute("/");
    }

    public function deleteAction($eventId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $event = $this->readAction($eventId);
        $entityManager->remove($event);
        $entityManager->flush();
    }

    // see app/config/routes.yaml
    public function indexAction(): Response
    {
        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }

    /**
     * @Route("/event/{id}", name="view_event", requirements={"id" = "\d+"})
     */
    public function viewEventAction($id = 0): Response
    {
        // this method will do a find by $id, the pass in the appropriate params to the twig template
        return $this->render('event/view_event.html.twig', [
            'controller_name' => 'UNDER CONSTRUCTION',
        ]);
    }

    /**
     * @Route("/events/{page}", name="view_events", requirements={"page" = "\d+"})
     */
    public function viewEventsListAction($page = 1): Response
    {
        // this method will do a find by $id, the pass in the appropriate params to the twig template
        return $this->render('event/view_events.html.twig', [
            'controller_name' => 'UNDER CONSTRUCTION',
        ]);
    }

    public function editEventAction($id): Response
    {
        $record = false;
        if (!$record || !$id) {
            throw $this->createNotFoundException("Record not found");
        }

        return $this->redirectToRoute("/event/"+$id);
    }

    public function eventAsJsonAction($id): Response
    {
        $record = false;
        return $this->json(["key" => "value"]);
    }
}
