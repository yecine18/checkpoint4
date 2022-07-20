<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
   
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        // $user = $this->getUser();
        $user=$this->UserRepository->findAll();

        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }
}
