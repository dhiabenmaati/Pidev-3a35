<?php

namespace App\Controller\Admin;

use App\Entity\Admin\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(UserRepository $userRepository)
    {
        $users =  $userRepository->findAll() ;
        $TotalUsers = sizeof($users) ;
        return $this->render('admin/admin/index.html.twig', [
            'TotalUsers' => $TotalUsers,
        ]);
    }
}
