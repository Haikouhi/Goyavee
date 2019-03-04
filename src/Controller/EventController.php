<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Comment;
use App\Entity\Status;
use App\Entity\Location;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="event_index", methods={"GET"})
     */
    
    public function index(EventRepository $eventRepository, CategoryRepository $categoryRepository): Response
    {

        if ($this->getUser()) {
            
            $events = $eventRepository->findAll();
            $categories = $categoryRepository->findAll();
            return $this->render('event/index.html.twig', [
            'events' => $events,
            'categories' => $categories,
        ]);   
        }

        $events = $eventRepository->findAll();
        $categories = $categoryRepository->findAll();
        return $this->render('event/index.html.twig', [
            'events' => $events,
            'categories' => $categories,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/new", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);

        //retieve the id of the current user
        $actualUser = $this->getUser();
        //set the organizer with the current user
        $event->setOrganizer($actualUser);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


        /**********************************************************************/

            //retrive the file send in the request
            $file = $request->files->get('event')['photo'];

            //put the path to the folder that will stock our files in a var
            $uploads_event_directory = $this->getParameter('uploads_event_directory');

            //create a var to change the name of the file
            $filename = md5(uniqid()) . '.' . $file->guessExtension();

            //move the file into the folder
            $file->move(
                $uploads_event_directory,
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
     * @IsGranted("ROLE_USER")
     * @Route("/{id}", name="event_show", methods={"GET", "POST"})
     */
    public function show(Request $request, Event $event): Response
    {

        
        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);


        //retieve the id of the current user
        $actualUser = $this->getUser();
        
        
        // dump($actualUser); die;
        //set the organizer with the current user
        $comment->setUser($actualUser);
        

        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

        }

        // dump($event); dump($commentForm); die;

        return $this->render('event/show.html.twig', [
            'event' => $event,
            'commentForm' => $commentForm->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}/edit", name="event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event): Response
    {
        if ($this->getUser()->getId() !== $event->getOrganizer()->getId()) {
            return $this->redirectToRoute('event_index');
        }
        
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
            'user' => $this->getUser(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
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

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/participate/{id}", name="event_participate", methods={"POST"})
     */

     public function participate(Request $request, Event $event): Response
     {

    $currentEvent =  $request->get("event");  
    
     $status = new Status();
     $status->setName("participe");
     $status->setUser($this->getUser());
     $status->setEvent($currentEvent); 
      
     $entityManager = $this->getDoctrine()->getManager();
     $entityManager->persist($status);
     $entityManager->flush();


     return $this->redirectToRoute('event_index');

    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/interested/{id}", name="event_interest", methods={"POST"})
     */

    public function interestedIn(Request $request, Event $event): Response
    {

        $currentEvent =  $request->get("event");

        $status = new Status();
        $status->setName("intéressé");
        $status->setUser($this->getUser());
        $status->setEvent($currentEvent);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($status);
        $entityManager->flush();


        return $this->redirectToRoute('event_index');

    }

}