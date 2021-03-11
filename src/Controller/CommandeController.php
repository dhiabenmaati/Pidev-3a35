<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Commande;
use App\Entity\DetailCommande;
use App\Repository\CommandeRepository;
use App\Repository\DetailCommandeRepository;



class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="commande")
     */
    public function index(CommandeRepository $CommandeRepository): Response
    {
        $commandes = $CommandeRepository->findAll();
        $cmd_info = [];
        foreach($commandes as $cmd) {
            $cmd_info[] = [
                'commande' => $CommandeRepository->find($cmd->getId()),
                'id' => $cmd->getId()
            ];
        }
       // dd($cmd_info);
        return $this->render('commande/index.html.twig', [
            'cmd_infos' => $cmd_info
        ]);
    }


    /**
     * @Route("/commande/add", name="commande_add")
     */
    public function add(SessionInterface $session, ProduitRepository $ProduitRepository) : Response
    {
        $panier = $session->get('panier');
        $entityManager = $this->getDoctrine()->getManager();
        $panier = $session->get('panier', []);
        $panierWithData = [];
        foreach($panier as $id => $qte) {
            $panierWithData[] = [
                'produit' => $ProduitRepository->find($id),
                'qte' => $qte
            ];
        }
        if(!empty($panierWithData)) {
            $date = new \DateTime();
            $cmd = new Commande();
            $cmd->setDateCreer(new \DateTime());
            $cmd->setDateExpedirer(NULL);
            $cmd->setStatus(0);
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
