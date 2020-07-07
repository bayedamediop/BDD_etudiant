<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;





/**
 * @Route("/etudiant")
 */
class EtudiantController extends AbstractController
{
    /**
     * @Route("/", name="etudiant_index", methods={"GET"})
     */
    public function index(EtudiantRepository $etudiantRepository,PaginatorInterface $paginator,Request $request): Response
    {
        $etudiant = new Etudiant();
        $allEtudiant= $etudiantRepository->findAll();
        $etudiant = $paginator->paginate(
            $allEtudiant, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            11/*limit per page*/
        );
        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiant,
        ]);
    }



    /**
     * @Route ("/Search", name="Search", methods={"GET","POST"})
     */

    public function search(Request $request)
    {
        $form = $this->createFormBuilder()->add('recherche', SearchType::class)->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->container->get('doctrine')->getManager();
            $etudiant = $em->getRepository('App\Entity\Etudiant')->search($data['recherche']);
            return $this->render('pages/etudiant/new.html.twig', [
                'etudiant' => $etudiant,
                'form' => $form->createView(),
            ]);
        }

    }
    /**
     * @Route("/new", name="etudiant_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
       // $mat=$this->maxId();
        $date=Date('yy');
        $etudiant = new Etudiant();
        $nom=$etudiant->getNom();
        $prenom=$etudiant->getPrenom();
        $cc= strtoupper (substr("$nom",0,2));
        $ll=strtoupper(substr("$prenom",-2));
        $matricule=$date."".$cc."".$ll;

        $etudiant->setMatricule($matricule);
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($etudiant);
            $entityManager->flush();

            return $this->redirectToRoute('etudiant_index');
        }

        return $this->render('etudiant/new.html.twig', [
            'etudiant' => $etudiant,

            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="etudiant_show", methods={"GET"})
     */
    public function show(Etudiant $etudiant): Response
    {
        return $this->render('etudiant/show.html.twig', [
            'etudiant' => $etudiant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="etudiant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Etudiant $etudiant): Response
    {
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('etudiant_index');
        }

        return $this->render('etudiant/edit.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="etudiant_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Etudiant $etudiant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etudiant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($etudiant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('etudiant_index');
    }
}
