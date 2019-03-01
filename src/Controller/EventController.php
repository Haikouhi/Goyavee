<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Location;
use App\Form\EventType;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="event_index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {
        
        $events = $eventRepository->findAll();

        return $this->render('event/index.html.twig', [
            'events' => $events,
        ]);
    }

    /**
     * @Route("/new", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

      

        // dump($request->request); die;
        // dump($_POST[location[street_name]]); die;

        // if (!$location) {

        //     $location = new Location();
        //     $location->setStreetName('Rue Flantier');
        //     $location->setZip(56000);
        //     $location->setCity('Lyon');
        //     $location->setCountry('France');
        //     $location->setLongitude(45.454);
        //     $location->setLatitude(45.454);

        //     // dump($location); die;
    
        //     $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist($location);
        //     $entityManager->flush();

            

        // }
      
        
            // dump($location); die;
            

        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
         //retieve the id of the current user

         $actualUser = $this->getUser();

         //set the organizer with the current user
 
         $event->setOrganizer($actualUser);
 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // echo "<pre>";
            // var_dump($this->getUser()->getId());
            // var_dump($request->request->get('event')['organizer']);
            // var_dump($request); die;

        /********************************* ************************************/

            //retrive the file send in the request
            $file = $request->files->get('event')['photo'];

            //put the path to the folder that will stock our files in a var
            $uploads_directory = $this->getParameter('uploads_directory');

            //create a var to change the name of the file
            $filename = md5(uniqid()) . '.' . $file->guessExtension();

            //move the file into the folder
            $file->move(
                $uploads_directory,
                $filename
            );

            //set the event photo's attribut
            $post = $event->setPhoto($filename);

        /**********************************************************************/    


       
        

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_show", methods={"GET"})
     */
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_index', [
                'id' => $event->getId(),
            ]);
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Event $event): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_index');
    }
}
