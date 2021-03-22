<?php

namespace App\Controller;

use App\Entity\CommentBlog;
use App\Entity\Reclamation;
use App\Entity\ReponseReclamation;
use App\Form\CommentBlogType;
use App\Form\ReclamationType;
use App\Form\ReponseReclamationType;
use App\Repository\BlogRepository;
use App\Repository\CommentBlogRepository;
use App\Repository\ReclamationRepository;
use App\Repository\ReponseReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReponseReclamationController extends AbstractController
{
    /**
     * @Route("/reponse/reclamation", name="reponse_reclamation")
     */
    public function index(): Response
    {
        return $this->render('reponse_reclamation/index.html.twig', [
            'controller_name' => 'ReponseReclamationController',
        ]);
    }

    /**
     * @Route("/reponse_reclamations", name="affiche_reponse_reclamation")
     * @param ReponseReclamationRepository $repository
     * @return Response
     */
    function AfficheReponseReclamation(ReponseReclamationRepository $repository) {
        $reponse_reclamations=$repository->findAll();
        return $this->render("reponse_reclamation/AfficheReponseReclamation.html.twig", ['reponse_reclamations'=>$reponse_reclamations]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route("/reponse_reclamations/modifier/{id}")
     */
    function UpdateC(Request $request, int $id) {
        $repo=$this->getDoctrine()->getRepository(ReponseReclamation::class);
        $entityManage=$this->getDoctrine()->getManager();
        $oldClass=$repo->find($id);
        $form=$this->createForm(ReponseReclamationType::class, $oldClass);
        $form->add("Update", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("affiche_reponse_reclamation");
        }
        $title = "Update".$oldClass->getId();
        return $this->render("reponse_reclamation/AddReponseReclamation.html.twig", [
            'f' =>$form->createView(),
            'page_title' => $title
        ]);

    }
    /**
     * @Route("/reponse_reclamations/supprimer/{id}")
     * @param int $id
     * @return RedirectResponse
     */
    function Delete(int $id) {
        $repo=$this->getDoctrine()->getRepository(ReponseReclamation::class);
        $entityManage=$this->getDoctrine()->getManager();
        $class=$repo->find($id);
        $entityManage->remove($class);
        $entityManage->flush();
        return $this->redirectToRoute("affiche_reponse_reclamation");
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * @param ReponseReclamationRepository $repository
     * @param int $id
     * @return Response
     * @Route("/reponse_reclamations/reponse/{id}", name="reponse_reclamation_valid_id")
     */
    function reponse_reclamation_valid_id(ReponseReclamationRepository $repository, int $id)
    {
        $reponse_reclamations=$repository->findBy(['id_rec' => $id ]);
        return $this->render('reponse_reclamation/AfficheReponseReclamation.html.twig',
            ['reponse_reclamations'=>$reponse_reclamations]
        );
    }
///////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * @Route("/reponse_reclamations/add/{id}", name="add_reponse_reclamation_id")
     * @param int $id
     * @param ReclamationRepository $repository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function add_reponse_reclamation_id(int $id, ReclamationRepository $repository,
                         Request $request)
    {
        $reclamations=$repository->find($id);
        $reponses = new ReponseReclamation();
        $form=$this->createForm(ReponseReclamationType::class,$reponses);
        $form->add("Ajouter", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $reponses->setIdRec($reclamations);
            $em=$this->getDoctrine()->getManager();
            $em->persist($reponses);
            $em->flush();
            return $this->redirectToRoute("affiche_reponse_reclamation");
        }

        return $this->render('reponse_reclamation/AddReponseReclamation.html.twig',[
            'reclamations'=>$reclamations,
            'reponses'=>$reponses,
            'f' =>$form->createView()
        ]);

    }

}
