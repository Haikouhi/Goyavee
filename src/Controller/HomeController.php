<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class HomeController extends AbstractController
{
    /**
     * Index public
     * @Route("/", name="app_index")
     * @Route("/home", name="home")
     */
    public function index()
    {

        if ($this->getUser()) {
            return $this->render('home/indexauth.html.twig');    
        }

        return $this->render('home/index.html.twig');
    }

}
