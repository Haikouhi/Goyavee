<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\EventRepository;
use App\Repository\CategoryRepository;

class HomeController extends AbstractController
{
    /**
     * Index public
     * @Route("/", name="app_index")
     */
    public function index(EventRepository $eventRepository, CategoryRepository $categoryRepository)
    {

        $categories = $categoryRepository->findAll();
        $events = $eventRepository->findAll();
        return $this->render('home/index.html.twig', [
            'categories' => $categories,
            'events' => $events,
        ]);
    }

}
