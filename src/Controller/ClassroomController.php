<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    /**
     * @Route("/classroom", name="classroom")
     */
    public function index()
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }

    /**
     * @Route("/classroom_affiche", name="classroom_Affiche")
     * @param ClassroomRepository $repo
     * @return Response
     */
    function AfficheC(ClassroomRepository $repo) {
        // $repo=$this->getDoctrine()->getRepository(Classroom::class);
        $classrooms=$repo->findAll();
        return $this->render("classroom/AfficheC.html.twig", ['classrooms'=>$classrooms]);
    }

    /**
     * @Route("/classroom_delete/{id}")
     * @param int $id
     * @return RedirectResponse
     */
    function Delete(int $id) {
        $repo=$this->getDoctrine()->getRepository(Classroom::class);
        $entityManage=$this->getDoctrine()->getManager();
        $class=$repo->find($id);
        $entityManage->remove($class);
        $entityManage->flush();
        return $this->redirectToRoute("classroom_Affiche");
    }
    /**
     * @Route("/classroom_add")
     */
    function AjoutClassroom(Request $request) {
        $classroom = new Classroom();
        $form=$this->createForm(ClassroomType::class, $classroom);
        $form->add("Ajouter", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($classroom);
            $em->flush();
            return $this->redirectToRoute("classroom_Affiche");
        }
        $title = "Add new classroom ";
        return $this->render("classroom/addClassroom.html.twig", [
            'f' =>$form->createView(),
            'page_title' => $title
        ]);

    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route("/classroom_update/{id}")
     */
    function UpdateC(Request $request, int $id) {
        $repo=$this->getDoctrine()->getRepository(Classroom::class);
        $entityManage=$this->getDoctrine()->getManager();
        $oldClass=$repo->find($id);
        $form=$this->createForm(ClassroomType::class, $oldClass);
        $form->add("Update", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("classroom_Affiche");
        }
        $title = "Update".$oldClass->getName();
        return $this->render("classroom/addClassroom.html.twig", [
            'f' =>$form->createView(),
            'page_title' => $title
        ]);

    }

}
