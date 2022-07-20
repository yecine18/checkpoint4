<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'app_articles')]
    public function index(ArticlesRepository $articles): Response
    {
        $articles = $articles->findBy([]);
        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }
    #[Route('/admin/{id}', name: 'app_admin')]
    public function show(Articles $articles): Response
    {
        return $this->render('admin/articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }
    //delete
    #[Route('/user/{id}/delete', name: 'article_delete')]

    public function delete(
        Articles $articles,
        EntityManagerInterface $em,
        ArticlesRepository $articlesRepository
    ): Response {

        $articlesRepository->remove($articles);
        $em->flush();

        $this->addFlash('danger', 'Article supprimé avec succès.');
        return $this->redirectToRoute("app_home");
    }
}
