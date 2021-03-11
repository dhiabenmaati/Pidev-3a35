<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier_index")
     */
    public function index(SessionInterface $session, ProduitRepository $ProduitRepository)
    {
        $panier = $session->get('panier', []);
        $panierWithData = [];
        foreach($panier as $id => $qte) {
            $panierWithData[] = [
                'produit' => $ProduitRepository->find($id),
                'qte' => $qte
            ];
        }
        $total = 0;
        foreach($panierWithData as $item) {
            $total += $item['produit']->getPrixProd() * $item['qte'];
        }
        return $this->render('panier/index.html.twig', [
            'items' => $panierWithData,
            'total' => $total,
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="panier_add")
     */

    public function add($id, SessionInterface $session) {
        $panier = $session->get('panier', []);
        $panier[$id] = (empty($panier[$id]) ? 1 : $panier[$id] + 1);
        $session->set('panier', $panier);
        return $this->redirectToRoute("panier_index");
    }

    /**
     * @Route("panier/remove/{id}", name="panier_remove")
     */
    public function remove($id, SessionInterface $session) {
        $panier = $session->get('panier', []);
        if(!empty($panier[$id]))
            unset($panier[$id]);
        $session->set('panier', $panier);
        return $this->redirectToRoute("panier_index");
    }

    /**
     * @Route("panier/update/{id}", name="cart_update")
     */
  /*  public function update($id, SessionInterface $session) {
        $panier = $session->get('panier', []);
        $panier[$id] = 1;
        $session->set('panier', $panier);
        return $this->redirectToRoute("cart_index");
    }*/
}