<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
   
    #[Route('/user', name: 'app_user')]
    public function index(UserRepository $userRepository): Response
    {
         $user = $this->getUser();

        return $this->render('admin/articles/index.html.twig', [
            'user' => $user,
        ]);
    }
    // debut crud
    // show
    #[Route('/admin', name: 'app_admin')]
    public function show(): Response
    {
        return $this->render('admin/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
    //Update
    #[Route('/user/update', name: 'detail_update')]
    public function update(
        EntityManagerInterface $em,
        UserRepository $userRepository
    ): Response {

        $userRepository->update($this->getUser());
        $em->flush();

        $this->addFlash('danger', 'Article supprimé avec succès.');
        return $this->redirectToRoute("app_home");
    }
    //delete
    #[Route('/user/{id}/delete', name: 'article_delete')]

    public function delete(
        User $user,
        EntityManagerInterface $em,
        UserRepository $userRepository
    ): Response {

        $userRepository->remove($user);
        $em->flush();

        $this->addFlash('danger', 'Article supprimé avec succès.');
        return $this->redirectToRoute("app_home");
    }
    
}
