<?php

namespace App\Controller;

use App\Entity\Marketing;
use App\Form\MarketingType;
use App\Repository\MarketingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/marketing")
 */
class MarketingController extends AbstractController
{
    /**
     * @Route("/", name="marketing_index", methods={"GET"})
     */
    public function index(MarketingRepository $marketingRepository): Response
    {
        return $this->render('marketing/index.html.twig', [
            'marketings' => $marketingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="marketing_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $marketing = new Marketing();
        $form = $this->createForm(MarketingType::class, $marketing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($marketing);
            $entityManager->flush();

            return $this->redirectToRoute('marketing_index');
        }

        return $this->render('marketing/new.html.twig', [
            'marketing' => $marketing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="marketing_show", methods={"GET"})
     */
    public function show(Marketing $marketing): Response
    {
        return $this->render('marketing/show.html.twig', [
            'marketing' => $marketing,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="marketing_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Marketing $marketing): Response
    {
        $form = $this->createForm(MarketingType::class, $marketing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('marketing_index', [
                'id' => $marketing->getId(),
            ]);
        }

        return $this->render('marketing/edit.html.twig', [
            'marketing' => $marketing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="marketing_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Marketing $marketing): Response
    {
        if ($this->isCsrfTokenValid('delete'.$marketing->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($marketing);
            $entityManager->flush();
        }

        return $this->redirectToRoute('marketing_index');
    }
}
