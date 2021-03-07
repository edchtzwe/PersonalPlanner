<?php

namespace App\Controller;

// Controller is deprecated in 4.1, AbstractController is the way to go, so let's future proof ourselves
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
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
    public function viewEventListAction($page = 1): Response
    {
        // this method will do a find by $id, the pass in the appropriate params to the twig template
        return $this->render('event/view_events.html.twig', [
            'controller_name' => 'UNDER CONSTRUCTION',
        ]);
    }
}
