<?php 
    use Symfony\Component\HttpFoundation\Session\Session;

    $session = new Session();
    $panier = $session->get('panier', []);
    $cnt = 0;
    foreach($panier as $id => $qte) 
        $cnt += $qte;
    $container->loadFromExtension('twig', [
        'globals' => [
            'cnt' => $cnt,
        ],
    ]);