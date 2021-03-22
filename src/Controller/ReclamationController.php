<?php

namespace App\Controller;

use App\Entity\Add;
use App\Entity\Classroom;
use App\Entity\Reclamation;
use App\Form\AddType;
use App\Form\ClassroomType;
use App\Form\ReclamationType;
use App\Repository\ClassroomRepository;
use App\Repository\ReclamationRepository;
use App\Repository\ReponseReclamationRepository;
use MongoDB\BSON\Timestamp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReclamationController extends AbstractController
{
    /**
     * @Route("/reclamation", name="reclamation")
     */
    public function index(): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }
    /**
     * @Route("/reclamations/add", name="add_reclamation")
     * @param ReclamationRepository $reclamationRepository
     * @param ReponseReclamationRepository $reponseRepository
     */
    function Ajout(Request $request,ReclamationRepository $reclamationRepository,ReponseReclamationRepository $reponseRepository) {
        $reclamations=$reclamationRepository->findreclamation();
        $reponses=$reponseRepository->findAll();
        $reclamation = new Reclamation();
        $form=$this->createForm(ReclamationType::class, $reclamation);
        $form->add("Envoyer", SubmitType::class,[
            'attr'=>['class'=>'btn btn-primary']
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $date1=new \DateTime();
            $reclamation->setReclamationAt($date1);
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute("add_reclamation");
        }
        $title = "Add new";
        return $this->render("reclamation/AddReclamation.html.twig", [
            'f' =>$form->createView(),
            'reclamations'=>$reclamations,
            'reponses'=>$reponses,
            'page_title' => $title
        ]);

    }

    /**
     * @Route("/reclamations", name="affiche_reclamation")
     * @param ReclamationRepository $repository
     * @return Response
     */
    function AfficheReclamation(ReclamationRepository $repository) {
        $reclamations=$repository->findAll();
        return $this->render("reclamation/AfficheReclamation.html.twig", ['reclamations'=>$reclamations]);
    }

    /**
     * @Route("/reclamations/supprimer/{id}")
     * @param int $id
     * @return RedirectResponse
     */
    function Delete(int $id) {
        $repo=$this->getDoctrine()->getRepository(Reclamation::class);
        $entityManage=$this->getDoctrine()->getManager();
        $class=$repo->find($id);
        $entityManage->remove($class);
        $entityManage->flush();
        return $this->redirectToRoute("affiche_reclamation");
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @param int $id
     * @Route("/reclamations/valid/{id}")
     */
    function Valid(Request $request, int $id) {
        $repo=$this->getDoctrine()->getRepository(Reclamation::class);
        $oldClass=$repo->find($id);
        $oldClass->setStatusRec('valid');
        $date2=new \DateTime();
        $oldClass->setValidAt($date2);
        $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("affiche_reclamation");

    }
    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @param int $id
     * @Route("/reclamations/progress/{id}")
     */
    function Progress(Request $request, int $id) {
        $repo=$this->getDoctrine()->getRepository(Reclamation::class);
        $oldClass=$repo->find($id);
        $oldClass->setStatusRec('progress');
        $date3=new \DateTime();
        $oldClass->setProgressAt($date3);
        $em=$this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute( "affiche_reclamation");

    }
/////////////////////////////////////////////////////////////////////////////////////////////
//Notification Reclamation
    /**
     * @Route("/reclamations/Notifications", name="affiche_notification")
     * @param ReclamationRepository $repository
     * @return Response
     */
    function AfficheNotification(ReclamationRepository $repository) {
        $reclamations=$repository->findreclamation();
        return $this->render("reclamation/AfficheReclamation.html.twig", ['reclamations'=>$reclamations]);
    }

    /**
     * @Route("/reclamations/{type}", name="AfficheReclamationParType")
     * @param ReclamationRepository $repository
     * @param string $type
     * @return Response
     */
    function AfficheReclamationParType(ReclamationRepository $repository , string $type) {
        $reclamations=$repository->findBy(['type'=> $type]);
        return $this->render("reclamation/AfficheParTypeReclamation.html.twig", ['reclamations'=>$reclamations]);
    }
}
