<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Form\AdresseType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdresseController extends AbstractController
{
    /**
     * @Route("/adresse/ajouter", name="adresse_add")
     */
    public function add_address(Request $request) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $addresse = $em->getRepository(Adresse::class)->findOneBy([
            'user' => $this->getUser()
        ]);
        if($addresse != null) return $this->redirectToRoute('adresse_update');
        $addresse = new Adresse();
        $form = $this->createForm(AdresseType::class, $addresse)
        ->add('save', SubmitType::class, [
            'label' => 'Ajouter',
            'attr' => [
                'class' => 'btn btn-success'
            ]
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $addresse->setUser($this->getUser());
            $em->persist($addresse);
            $em->flush();
            $this->addFlash(
                'info',
                'Votre adresse est ajoutée avec succée !'
            );
            return $this->redirectToRoute('panier_index');
        }
        return $this->render('user/ajouteradresse.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/adresse/modifier", name="adresse_update")
     */
    public function update_adress(Request $request) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $addresse = $em->getRepository(Adresse::class)->findOneBy([
            'user' => $this->getUser()
        ]);
        $form = $this->createForm(AdresseType::class, $addresse)
        ->add('save', SubmitType::class, [
            'label' => 'Ajouter',
            'attr' => [
                'class' => 'btn btn-success'
            ]
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();   
            $addresse->setUser($this->getUser());
            $em->persist($addresse);
            $em->flush();
            $this->addFlash(
                'info',
                'Votre adresse est modifié avec succée !'
            );
            return $this->redirectToRoute('panier_index');
        }
        return $this->render('user/modifieradresse.html.twig',[
            'form' => $form->createView()
        ]);
    }
}