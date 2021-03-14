<?php

namespace App\Controller;

// Controller is deprecated in 4.1, AbstractController is the way to go, so let's future proof ourselves
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Entity\Event;
use App\Form\EventType;

use Doctrine\ORM\EntityManagerInterface;

use DateInterval;

class EventController extends AbstractController
{
    public function getRepository()
    {
        return $this->getDoctrine()
            ->getRepository(Event::class);
    }

    public function castEventObjToArray($event)
    {
        $eventObjArr = array(
            "Title"       => $event->getTitle(),
            "Description" => $event->getDescription(),
            "Start"       => $event->getStartTime()->format('Y-m-d'),
            "End"         => $event->getEndTime()->format('Y-m-d'),
            "Location"    => $event->getLocation(),
            "Priority"    => $event->getPriority(),
        );
        return $eventObjArr;
    }


    public function findOrError($event)
    {
        if (!$event) {
            throw $this->createNotFoundException("Coudln't find Event with id : ".$eventId);
        }
        return true;
    }

    // Create
    public function createAction($event)
    {
        // equivalent to adding an argument to this action like createAction(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        /*
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
        */

        // tells Doctrine you want to eventually save the product (no queries yet)
        $entityManager->persist($event);

        // actually executes the queries
        $entityManager->flush();

        return $event;
    }

    // Read
    public function readAction($eventId)
    {
        $repository = $this->getRepository();
        $event      = $repository->find($eventId);

        return $event;
    }

    public function getAllAction()
    {
        $repository = $this->getRepository();
        $allEvents  = $repository->findAll();
    }

    // Update
    public function updateAction($event)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($event);

        $entityManager->flush();

        return $event;
    }

    // Delete
    public function deleteAction($eventId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $event         = $this->readAction($eventId);

        $entityManager->remove($event);
        $entityManager->flush();
    }

    /**
    * @Route("/", name="home")
    */
    public function indexAction(): Response
    {
        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }

    /**
    * @Route("/event/add_event", name="add_event")
    */
    public function createNewEventAction(Request $request)
    {
        $event = new Event();
        $form  = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // this line is not really needed as the form auto-updates the entity object
            $event    = $form->getData();
            $newEvent = $this->createAction($event);

            return $this->redirectToRoute("view_event", array("id" => $newEvent->getId()));
        }

        return $this->render("event/add_event.html.twig", [
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/event/{id}", name="view_event", requirements={"id" = "\d+"})
     */
    public function viewEventAction($id)
    {
        $event       = $this->readAction($id);
        $eventObjArr = $this->castEventObjToArray($event);

        return $this->render('event/view_event.html.twig', [
            'event'     => $eventObjArr,
            "event_obj" => $event,
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

    /**
    * @Route("/event/edit/{id}", name="edit_event", requirements={"id" = "\d+"})
    */
    public function editEventAction(Request $request, $id): Response
    {
        $event = $this->readAction($id);
        
        $form  = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // this line is not really needed as the form auto-updates the entity object
            $event    = $form->getData();
            $newEvent = $this->createAction($event);

            return $this->redirectToRoute("view_event", array("id" => $newEvent->getId()));
        }

        return $this->render("event/add_event.html.twig", [
            "form" => $form->createView(),
        ]);

        return $this->redirectToRoute("/event/"+$id);
    }

    /**
    * @Route("/event/delete/{id}", name="delete_event", requirements={"id" = "\d+"})
    */
    public function deleteEventAction($id)
    {
        $this->deleteAction($id);

        $this->addFlash(
            "deleted_event_id", $id
        );

        return $this->redirectToRoute("home");
    }

    public function eventAsJsonAction($id): Response
    {
        $record = false;

        return $this->json(["key" => "value"]);
    }
}
