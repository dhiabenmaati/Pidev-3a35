<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Commande;
use App\Form\CommandeType;
use App\Entity\DetailCommande;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LivreurController extends AbstractController
{
    /**
     * @Route("/livreur", name="livreur")
     */
    public function index(): Response
    {
        return $this->render('livreur/show.html.twig');
    }

    /**
     * @Route("/livreur/commande", name="livreur_commande")
     */
    public function show_commande(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $liv = $this->getUser();
        $commandes = $em->getRepository(Commande::class)->findBy([
            'livreur' => $liv->getId()
        ]);
        return $this->render('livreur/listecommandes.html.twig', [
            'commandes' => $commandes
        ]);
    }

    /**
     * @Route("/livreur/commande/{id}", name="detail_commande_livreur")
     */
    public function aff_detail_cmd($id) {
        $em = $this->getDoctrine()->getManager();
        $cmd = $em->getRepository(Commande::class)->find($id);
        $detailCmds = $em->getRepository(DetailCommande::class)->findBy(
            ['commande' => $id]
        );
        $adress = $em->getRepository(Adresse::class)->findOneBy([
            'user' => $cmd->getUser()->getId()
        ]);
        $total = 0;
        foreach($detailCmds as $item)
          $total += $item->getProduit()->getPrixProd() * $item->getQte();
        return $this->render('livreur/detailcommande.html.twig',
        [
            'detailCmds' => $detailCmds,
            'total' => $total,
            'adresse' => $adress,
            'user' => $cmd->getUser(),
        ]);
    }


    /**
     * @Route("/livreur/commande/modifier/{id}", name="update_commande")
     */
    public function update_commande($id, Request $request, \Swift_Mailer $mailer) {
        $em = $this->getDoctrine()->getManager();
        $cmd = $em->getRepository(Commande::class)->find($id);
        $old_status = $cmd->getStatus();
        $form = $this->createForm(CommandeType::class, $cmd)
        ->add('save', SubmitType::class, [
            'label' => 'Modifier le status',
            'attr' => [
                'class' => 'btn btn-success'
            ]
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            if($cmd->getStatus() == 2) 
                $cmd->setDateExpedirer(new \DateTime());
            else if($old_status == 2) 
                $cmd->setDateExpedirer(null);
            $em->persist($cmd);
            $em->flush();
            $this->addFlash(
                'info',
                'Le status de commande est modifié avec succée !'
            );
            $user = $cmd->getUser();
            $detailCmds = $em->getRepository(DetailCommande::class)->findBy([
                'commande' => $id
            ]);
            $total = 0;
            foreach($detailCmds as $item)
                $total += $item->getProduit()->getPrixProd() * $item->getQte();
            $message = (new \Swift_Message('Authentication info'))
                ->setFrom('pisquad.piart@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                    'emails/commandeexp.html.twig',[
                        'user' => $user,
                        'detailCmds' => $detailCmds,
                        'total' => $total
                    ]),
                    'text/html'
                );
                $mailer->send($message);
            return $this->redirectToRoute('livreur_commande');
        }
        return $this->render('livreur/modifiercommande.html.twig', [
            'cmd' => $cmd,
            'user' => $cmd->getUser(),
            'form' => $form->createView()
        ]);
    }
}
