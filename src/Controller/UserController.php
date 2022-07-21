<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
        return $this->render('admin/articles/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
    //Edit
    #[Route('/{id}/edit', name: 'detail_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/articles/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    //delete
    #[Route('/user/delete', name: 'app_user_delete')]

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
