<?php

namespace App\Controller;

use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route("/api", name: "api_")]
class TwigController extends AbstractController
{
    #[Route('/twig', name: 'app_twig')]
    public function index(UserRepository $urepository, MessageRepository $mreposetory): Response
    {
        $allUser = $urepository->findAll();
        $allMessage = $mreposetory->findAll();


        return $this->render('twig/index.html.twig', array('data' => $allUser));
    }
}
