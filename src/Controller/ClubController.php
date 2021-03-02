<?php

namespace App\Controller;

use App\Entity\Club;
use App\Entity\Student;
use App\Form\ClubType;
use App\Repository\ClubRepository;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClubController extends AbstractController
{
    /**
     * @Route("/club", name="club")
     */
    public function index()
    {
        return $this->render('club/index.html.twig', [
            'controller_name' => 'ClubController',
        ]);
    }
    /**
     * @Route("/clubs_affiche", name="clubs_Affiche")
     * @param StudentRepository $repo
     * @return Response
     */
    function AfficheC(ClubRepository $repo) {
        // $repo=$this->getDoctrine()->getRepository(Classroom::class);
        $clubs=$repo->findAll();
        return $this->render("club/AfficheC.html.twig", ['clubs'=>$clubs]);
    }
    /**
     * @Route("/club_delete/{id}")
     * @param int $id
     * @return RedirectResponse
     */
    function Delete(int $id) {
        $repo=$this->getDoctrine()->getRepository(Club::class);
        $entityManage=$this->getDoctrine()->getManager();
        $club=$repo->find($id);
        $entityManage->remove($club);
        $entityManage->flush();
        return $this->redirectToRoute("clubs_Affiche");
    }
    /**
     * @Route("/club_add")
     */
    function AjoutClubs(Request $request) {
        $club = new Club();
        $form=$this->createForm(clubType::class, $club);
        $form->add("Ajouter", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();
            return $this->redirectToRoute("clubs_Affiche");
        }
        $title = "Add new club ";
        return $this->render("club/addClub.html.twig", [
            'f' =>$form->createView(),
            'page_title' => $title
        ]);

    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route("/club_update/{id}")
     */
    function UpdateC(Request $request, int $id) {
        $repo=$this->getDoctrine()->getRepository(Club::class);
        $entityManage=$this->getDoctrine()->getManager();
        $oldCLub=$repo->find($id);
        $form=$this->createForm(ClubType::class, $oldCLub);
        $form->add("Update", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("clubs_Affiche");
        }
        $title = "Update Club";
        return $this->render("club/addClub.html.twig", [
            'f' =>$form->createView(),
            'page_title' => $title
        ]);

    }
}
