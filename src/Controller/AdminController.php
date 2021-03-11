<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Commande;
use App\Entity\Produit;
use App\Entity\Livreur;
use App\Entity\DetailCommande;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use App\Repository\DetailCommandeRepository;
use App\Repository\LivreurRepository;
use App\Form\LivreurType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_home")
     */
    public function index(CommandeRepository $CommandeRepository): Response
    {   
        return $this->render('admin/index.html.twig');
    }


    /**
     * @Route("/gestion_commande", name="gestion_commande")
     */
    public function aff_commandes(CommandeRepository $CommandeRepository): Response
    {   
        $commandes = $CommandeRepository->findAll();
        return $this->render('admin/listecommandes.html.twig',
        [
            'commandes' => $commandes
        ]);
    }

    /**
     * @Route("/gestion_commande/{id}", name="detail_commande")
     */
    public function aff_detail_cmd($id) {
        $em = $this->getDoctrine()->getManager();
        $detailCmds = $em->getRepository(DetailCommande::class)->findBy(
            ['commande' => $id]
        );
        $total = 0;
        foreach($detailCmds as $item)
          $total += $item->getProduit()->getPrixProd() * $item->getQte();
        return $this->render('admin/detailcommande.html.twig',
        [
            'detailCmds' => $detailCmds,
            'total' => $total
        ]);
    }

    /**
     * @Route("/gestion_commande/supprimer/{id}", name="supprimer_commande")
     */
    public function supprimer_cmd($id) {
        $em = $this->getDoctrine()->getManager();
        $cmd = $em->getRepository(Commande::class)->find($id);
        
        $detaiCmds = $em->getRepository(DetailCommande::Class)->findByCommande($id);
        foreach ($detaiCmds as $item) 
            $em->remove($item);  
        $em->remove($cmd);
        $em->flush();
        $this->addFlash(
            'info',
            'Commande supprimée avec succée !'
        );
        return $this->redirectToRoute('gestion_commande');
    }

    /**
     * @Route("/gestion_commande/modifier/{id}", name="modifier_commande")
     */
    public function modifier_cmd($id) {
        $em = $this->getDoctrine()->getManager();
        $cmd = $em->getRepository(Commande::class)->find($id);
        $livs = $em->getRepository(Livreur::class)->findAll();
        return $this->render('admin/modifiercommande.html.twig', [
            'cmd' => $cmd,
            'livs' => $livs,
        ]);
    }

    /**
     * @Route("/gestion_commande/rechercher/", name="recherche_commande")
     */
    public function rech_cmd(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('id_cmd');
        $cmd = $em->getRepository(Commande::class)->find($id);
        if($request->isMethod('POST')) {
            if($cmd != NULL) {
                $this->addFlash(
                    'info',
                    'Commande Trouvée !'
                );
            } else {
                $this->addFlash(
                    'error',
                    'Commande Introuvable !'
                );
            }
            return $this->render('admin/recherchercommande.html.twig',[
                'cmd' => $cmd
            ]);
        } else 
        return $this->redirectToRoute('gestion_commande');
    }

    /**
     * @Route("/gestion_commande/affecter/{id}", name="affecter_livreur")
     */
    public function affect_liv(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $cmd = $em->getRepository(Commande::class)->find($id);
        $id_liv = $request->request->get('liv');
        $liv = $em->getRepository(Livreur::class)->find($id_liv);
        $cmd->setLivreur($liv);
        $cmd->setStatus(1);
        $em->persist($cmd);
        $em->flush();
        $this->addFlash(
            'info',
            'Livreur affecter avec succée !'
        );
        return $this->redirectToRoute('gestion_commande');
    }

    /**
     * @Route("/livreur/ajouter/", name="ajouter_livreur")
     */
    public function ajouter_livreur(Request $request) {
        $livreur = new Livreur();
        $form = $this->createForm(LivreurType::class, $livreur)->add('save', SubmitType::class, [
            'label' => 'Ajouter',
            'attr' => [
                'class' => 'btn btn-success'
            ]
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();   
            $em->persist($livreur);
            $em->flush();
            $this->addFlash(
                'info',
                'Livreur ajouté avec succée !'
            );
            return $this->redirectToRoute('affiche_livreurs');
        }
        return $this->render('admin/ajouterlivreur.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/livreur/afficher/", name="affiche_livreurs")
     */
    public function aff_livreur(LivreurRepository $livrepo) {
        $livreurs = $livrepo->findAll();
        return $this->render('admin/listelivreurs.html.twig', [
            'livreurs' => $livreurs
        ]);
    }
    
    /**
     * @Route("/livreur/supprimer/{id}", name="supprimer_livreur")
     */
    public function supprimer_liv($id) {
        $em = $this->getDoctrine()->getManager();
        $cmd = $em->getRepository(Livreur::class)->find($id);
        $entityManager->remove($cmd);
        $entityManager->flush();
        $this->addFlash(
            'info',
            'Livreur supprimé avec succée !'
        );
        return $this->redirectToRoute('affiche_livreurs');
    }

    /**
     * @Route("/livreur/modifier/{id}", name="modifier_livreur")
     */
    public function modifier_livreur(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $livreur = $em->getRepository(Livreur::class)->find($id);
        $form = $this->createForm(LivreurType::class, $livreur)
        ->add('save', SubmitType::class, [
            'label' => 'Modifier',
            'attr' => [
                'class' => 'btn btn-success'
            ]
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();   
            $em->persist($livreur);
            $em->flush();
            return $this->redirectToRoute('affiche_livreurs');
            $this->addFlash(
                'info',
                'Livreur modifié avec succée !'
            );
        }
        return $this->render('admin/modifierlivreur.html.twig', [
            'form' => $form->createView()
        ]);
    }


}
