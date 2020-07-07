<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Form\ChambreType;
use App\Repository\ChambreRepository;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;
/**
 * @Route("/chambre")
 */
class ChambreController extends AbstractController
{
    /**
     * @Route("/chambre", name="chambre_index", methods={"GET"})
     * @param ChambreRepository $chambreRepository

     * @param Request $request
     * @return Response
     */
    public function index(ChambreRepository $chambreRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $allChambres= $chambreRepository->findAll();
        $chambres = $paginator->paginate(
            $allChambres, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        return $this->render('chambre/index.html.twig', [
            'chambres' => $chambres,
        ]);
    }

    /**
     * @Route("/new", name="chambre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $chambre = new Chambre();
        $form = $this->createForm(ChambreType::class, $chambre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($chambre);
            $entityManager->flush();

            return $this->redirectToRoute('chambre_index');
        }

        return $this->render('chambre/new.html.twig', [
            'chambre' => $chambre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="chambre_show", methods={"GET"})
     */
    public function show(Chambre $chambre): Response
    {
        return $this->render('chambre/show.html.twig', [
            'chambre' => $chambre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="chambre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Chambre $chambre): Response
    {
        $form = $this->createForm(ChambreType::class, $chambre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('chambre_index');
        }

        return $this->render('chambre/edit.html.twig', [
            'chambre' => $chambre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="chambre_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Chambre $chambre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chambre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($chambre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('chambre_index');
    }
}
