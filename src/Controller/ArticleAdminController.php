<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/admin/article/new", name="admin_article_new")
     * @isGranted("ROLE_ADMIN_ARTICLE")
     */
    public function new(EntityManagerInterface $em, Request $request)
    {
        $form= $this->createForm(ArticleFormType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $data=$form->getData();
            $article= new Article;
            $article->setTitle($data['title']);
            $article->setContent($data['content']);
            $article->setAuthor($this->getUser());

            $em->persist($article);
            $em->flush();

            $this->addFlash('success','Article Created! Knowledge is power!');

            return $this->redirectToRoute('admin_article_list');
        }
        return $this->render('article_admin/new.html.twig',[
            'articleForm' => $form->createView(),
        ]);
    }

    //will use the {id} route parameter to query for the correct Article.
   

    //When you use subject=, you're allowed to pass this the same name as any of the arguments
    //to your controller. This only works because we used the feature that automatically
    //queries for the Article object and passes it as an argument. 
    //These two features combine perfectly. But, if you're ever in a situation where your 
    //"subject" isn't a controller argument, no worries, just use the normal 
    //denyAccessUnlessGranted() code.

     /**
     * @Route("/admin/article/{id}/edit")
     * @isGranted("MANAGE",subject="article")
     */
    public function edit(Article $article)
    {
        //$this->denyAccessUnlessGranted('MANAGE', $article);
        dd($article);
    }

    /**
     * @Route("/admin/article", name="admin_article_list")
     */
    public function list(ArticleRepository $articleRepo)
    {
            $articles=$articleRepo->findAll();
            return $this->render('article_admin/list.html.twig',[
                'articles' => $articles,
            ]);
    }
}
