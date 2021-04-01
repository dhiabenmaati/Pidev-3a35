<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\Livreur;
use App\Entity\Commande;
use App\Form\LivreurType;
use App\Entity\Admin\User;
use App\Form\CommandeType;
use App\Entity\DetailCommande;
use App\Repository\UserRepository;
use App\Repository\LivreurRepository;
use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_home")
     */
    public function index(): Response
    {   
        return $this->render('admin/admin/index.html.twig');
    }


    /**
     * @Route("/admin/commande", name="gestion_commande")
     */
    public function aff_commandes(Request $request): Response
    {   
        $em = $this->getDoctrine()->getManager();
        $commandes = $em->getRepository(Commande::class)->findAll();
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {  
            $jsonData = array();  
            $idx = 0; 
            foreach($commandes as $commande) {  
               $temp = array(
                    'id' => $commande->getId(),
                    'date_creer' => $commande->getDateCreer(),
                    'date_expedirer' => $commande->getDateExpedirer(),
                    'status' => $commande->getStatus(),
                    'user' => $commande->getUser()->getId(),
                    'livreur' => $commande->getLivreur() != null ? $commande->getLivreur()->getId() : null,
               );
               $jsonData[$idx++] = $temp;  
            } 
            return new JsonResponse($jsonData); 
        }
        return $this->render('admin/commande/listecommandes.html.twig',[
            'commandes' => $commandes
        ]);
    }


    /**
    * @Route("admin/commande/rechercher", name="recherche_commande", methods="POST")
    */
    public function recherche_commande(Request $request) {
        if ($request->isXmlHttpRequest()) {
            $id = $request->request->get('id');
            $em = $this->getDoctrine()->getManager();
            $cmd = $em->getRepository(Commande::class)->find($id);
            $cmd_array = [];
            if($cmd != null) {
                $cmd_array['id'] = $cmd->getId();
                $cmd_array['date_creer'] = $cmd->getDateCreer();
                $cmd_array['date_expedirer'] = $cmd->getDateExpedirer();
                $cmd_array['status'] = $cmd->getStatus();
                $cmd_array['user'] = $cmd->getUser()->getId();
                $cmd_array['livreur'] = $cmd->getLivreur() != null ? $cmd->getLivreur()->getId() : null;
            }
            return new JsonResponse($cmd_array);
        }
        return $this->redirectToRoute('gestion_commande');
    }




    /**
     * @Route("/admin/commande/{id}", name="detail_commande")
     */
    public function aff_detail_cmd($id) {
        $em = $this->getDoctrine()->getManager();
        $detailCmds = $em->getRepository(DetailCommande::class)->findBy(
            ['commande' => $id]
        );
        $total = 0;
        foreach($detailCmds as $item)
          $total += $item->getProduit()->getPrixProd() * $item->getQte();
        return $this->render('admin/commande/detailcommande.html.twig',
        [
            'detailCmds' => $detailCmds,
            'total' => $total
        ]);
    }

    /**
     * @Route("/admin/commande/supprimer/{id}", name="supprimer_commande")
     */
    public function supprimer_cmd($id) {
        $em = $this->getDoctrine()->getManager();
        $cmd = $em->getRepository(Commande::class)->find($id);
        
        $detaiCmds = $em->getRepository(DetailCommande::class)->findBy(
            ['commande' => $id]
        );
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
     * @Route("/admin/commande/modifier/{id}", name="modifier_commande")
     */
    public function modifier_cmd($id, UserRepository $userrepo, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $cmd = $em->getRepository(Commande::class)->find($id);
        $livs = $userrepo->findByRole('LIVREUR');
        return $this->render('admin/commande/modifiercommande.html.twig', [
            'cmd' => $cmd,
            'livs' => $livs,
        ]);
    }


    /**
     * @Route("/admin/commande/affecter/{id}", name="affecter_livreur")
     */
    public function affect_liv(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $cmd = $em->getRepository(Commande::class)->find($id);
        $id_liv = $request->request->get('liv');
        $liv = $em->getRepository(User::class)->find($id_liv);
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
     * @Route("/admin/livreur/", name="affiche_livreurs")
     */
    public function aff_livreur(UserRepository $userrepo, Request $request) {
        $livreurs = $userrepo->findByRole('LIVREUR');
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {  
            $jsonData = array();  
            $idx = 0;  
            foreach($livreurs as $livreur) {  
               $temp = array(
                  'id' => $livreur->getId(),  
                  'nom' => $livreur->getSurname(),  
                  'prenom' => $livreur->getName(),
                  'email' => $livreur->getEmail(),
                  'num_tel' => $livreur->getNumTel(),
               );   
               $jsonData[$idx++] = $temp;  
            } 
            return new JsonResponse($jsonData); 
        }
        return $this->render('admin/livreur/listelivreurs.html.twig', [
            'livreurs' => $livreurs
        ]);
    }
    
    /**
     * @Route("/admin/livreur/supprimer/{id}", name="supprimer_livreur")
     */
    public function supprimer_liv($id) {
        $em = $this->getDoctrine()->getManager();
        $liv = $em->getRepository(User::class)->find($id);
        $cmds = $em->getRepository(Commande::class)->findBy(
            ['livreur' => $id]
        );
        foreach($cmds as $cmd) {
            $cmd->setLivreur(null);
        }
        $em->remove($liv);
        $em->flush();
        $this->addFlash(
            'info',
            'Livreur supprimé avec succée !'
        );
        return $this->redirectToRoute('affiche_livreurs');
    }

    /**
     * @Route("/admin/livreur/modifier/{id}", name="modifier_livreur")
     */
    public function modifier_livreur(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $livreur = $em->getRepository(User::class)->find($id);
        $form = $this->createForm(LivreurType::class, $livreur)
        ->add('save', SubmitType::class, [
            'label' => 'Modifier',
            'attr' => [
                'class' => 'btn btn-success'
            ]
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();   
            $em->persist($livreur);
            $em->flush();
            return $this->redirectToRoute('affiche_livreurs');
            $this->addFlash(
                'info',
                'Livreur modifié avec succée !'
            );
        }
        return $this->render('admin/livreur/modifierlivreur.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/livreur/ajouter", name="ajouter_livreur", methods={"GET","POST"})
     */
    public function ajouter_livreur(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer): Response
    {
        $livreur = new User();
        $form = $this->createForm(LivreurType::class, $livreur)->add('save', SubmitType::class, [
            'label' => 'Ajouter',
            'attr' => [
                'class' => 'btn btn-success'
            ]
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $livreur->setPassword(
                $passwordEncoder->encodePassword(
                    $livreur,
                    $form->get('password')->getData()
                )
            );
            $entityManager->persist($livreur);
            $entityManager->flush();
            
            $this->addFlash(
                'info',
                'Livreur ajouté avec succée !'
            );
            $message = (new \Swift_Message('Authentication info'))
                ->setFrom('pisquad.piart@gmail.com')
                ->setTo($livreur->getEmail())
                ->setBody(
                    $this->renderView(
                    'emails/livreurinfo.html.twig',[
                        'liv' => $livreur,
                        'pass' => $form->get('password')->getData()
                    ]),
                    'text/html'
                );
                $mailer->send($message);
            return $this->redirectToRoute('affiche_livreurs');
        }

        return $this->render('admin/livreur/ajouterlivreur.html.twig', [
            'livreur' => $livreur,
            'form' => $form->createView()
        ]);
    }


    /**Recherche avec ajax */
    
    /** 
     * @Route("/admin/livreur/recherche", name="recherche_livreur", methods="get")
    */
    public function searchAction(Request $request, UserRepository $userrepo)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $entities =  $userrepo->findEntitiesByString($requestString);
        if(!$entities) {
            $result['entities']['error'] = "Livreur inexistant !";
        } else {
            $result['entities'] = $this->getRealEntities($entities);
        }
        return new Response(json_encode($result));
    }

    public function getRealEntities($entities) {
        foreach ($entities as $entity){
            $realEntities[$entity->getId()] = $entity->getName() . ' ' . $entity->getSurname();
        }
        return $realEntities;
    }

    /**
     * @Route("/admin/livreur/consulter/{id}", name="consulter_livreur")
     */
    public function consulter_livreur($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $liv = $em->getRepository(User::class)->find($id);
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {  
            $jsonData = array();  
            $idx = 0; 
            $commandes = $em->getRepository(Commande::class)->findBy([
                'livreur' => $id
            ]);
            foreach($commandes as $commande) {  
               $temp = array(
                    'id' => $commande->getId(),
                    'date_creer' => $commande->getDateCreer(),
                    'date_expedirer' => $commande->getDateExpedirer(),
                    'status' => $commande->getStatus(),
                    'user' => $commande->getUser()->getId(),
                    'livreur' => $commande->getLivreur()->getId(),
               );
               $jsonData[$idx++] = $temp;  
            } 
            return new JsonResponse($jsonData); 
        }
        return $this->render('admin/livreur/consulter.html.twig',[
            'liv' => $liv,
        ]);
    }

    /**
     * @Route("/admin/commandenonlivrer", name="commande_non_livrer")
     */
    public function aff_commande_non_livrer(Request $request, CommandeRepository $repo): Response
    {   
        $commandes = $repo->findByNotStatus(2);
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {  
            $jsonData = array();  
            $idx = 0; 
            foreach($commandes as $commande) {  
               $temp = array(
                    'id' => $commande->getId(),
                    'date_creer' => $commande->getDateCreer(),
                    'date_expedirer' => $commande->getDateExpedirer(),
                    'status' => $commande->getStatus(),
                    'user' => $commande->getUser()->getId(),
                    'livreur' => $commande->getLivreur() != null ? $commande->getLivreur()->getId() : null,
               );
               $jsonData[$idx++] = $temp;  
            } 
            return new JsonResponse($jsonData); 
        }
        return $this->render('admin/commande/listecommandes.html.twig',[
            'commandes' => $commandes
        ]);
    }

}