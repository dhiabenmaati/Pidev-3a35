<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Commande;
use App\Entity\DetailCommande;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="commande")
     */
    public function index(CommandeRepository $CommandeRepository): Response
    {
        $commandes = $CommandeRepository->findBy([
            'user' => $this->getUser()
        ]);
        $cmd_info = [];
        foreach($commandes as $cmd) {
            $cmd_info[] = [
                'commande' => $CommandeRepository->find($cmd->getId()),
                'id' => $cmd->getId()
            ];
        }
        return $this->render('commande/index.html.twig', [
            'cmd_infos' => $cmd_info
        ]);
    }

    /**
     * @Route("/commande/ajouter", name="commande_add")
     */
    public function add(SessionInterface $session, ProduitRepository $ProduitRepository, \Swift_Mailer $mailer) : Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(Adresse::class)->findBy([
            'user' => $this->getUser()
        ]);
        if($user == null) {
            $this->addFlash(
                'info',
                "Vous devez donner votre adresse pour l'expédition !"
            );
            return $this->redirectToRoute('adresse_add');
        }
        $panier = $session->get('panier');
        $panier = $session->get('panier', []);
        $panierWithData = [];
        foreach($panier as $id => $qte) {
            $panierWithData[] = [
                'produit' => $ProduitRepository->find($id),
                'qte' => $qte
            ];
        }
        if(!empty($panierWithData)) {
            $cmd = new Commande();
            $cmd->setDateCreer(new \DateTime());
            $cmd->setDateExpedirer(NULL);
            $cmd->setStatus(0);
            $cmd->setUser($this->getUser());
            $entityManager->persist($cmd);
            $entityManager->flush();
            foreach($panierWithData as $item) {
                $cmd_detail = new DetailCommande();
                $cmd_detail->setCommande($cmd);
                $cmd_detail->setProduit($item['produit']);
                $cmd_detail->setQte($item['qte']);
                $entityManager->persist($cmd_detail);
                $entityManager->flush();
            }
            $em = $this->getDoctrine()->getManager();
            $detailCmds = $em->getRepository(DetailCommande::class)->findBy(
                ['commande' => $cmd->getId()]
            );

            $total = 0;
            foreach($detailCmds as $item)
              $total += $item->getProduit()->getPrixProd() * $item->getQte();

              $user = $this->getUser();
              $message = (new \Swift_Message('PiArt'))
                      ->setFrom('pisquad.piart@gmail.com')
                      ->setTo($user->getEmail())
                      ->setBody(
                          $this->renderView(
                          'emails/commandeinfo.html.twig',[
                              'user' => $user,
                              'detailCmds' => $detailCmds,
                              'total' => $total
                          ]),
                          'text/html'
                      );
                 $mailer->send($message);
        }
        return $this->redirectToRoute("commande");
    }

    /**
     * @Route("/commande/{id}", name="detail_cmd_user")
     */
    public function aff_detail_cmd($id) {
        $em = $this->getDoctrine()->getManager();
        $detailCmds = $em->getRepository(DetailCommande::class)->findBy(
            ['commande' => $id]
        );
        $total = 0;
        foreach($detailCmds as $item)
          $total += $item->getProduit()->getPrixProd() * $item->getQte();
        return $this->render('commande/detailcommande.html.twig',
        [
            'detailCmds' => $detailCmds,
            'total' => $total
        ]);
    }


}
