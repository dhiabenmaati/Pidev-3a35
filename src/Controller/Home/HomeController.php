<?php

namespace App\Controller\Home;

use App\Entity\Admin\Messages;
use App\Entity\Admin\Product;
use App\Form\Admin\MessagesType;
use App\Repository\Admin\CommentRepository;
use App\Repository\Admin\ImageRepository;
use App\Repository\Admin\ProductRepository;
use App\Repository\Admin\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {

        return $this->render('home/index.html.twig', []);
    }



}
