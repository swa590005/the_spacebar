<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\MarkdownHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Nexy\Slack\Client;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    /**
     * Undocumented function
     *
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render('article/homepage.html.twig');
    }


    /**
     * @Route("news/{slug}", name="article_show")
     */

    public function show($slug, Client $slack, EntityManagerInterface $em)
    {
        if ($slug === 'khaaaaaan') {
            $message = $slack->createMessage()
                ->from('Khan')
                ->withIcon(':ghost:')
                ->setText('Ah, Kirk, my old friend...');
            $slack->sendMessage($message);
        }
        
        $repository=$em->getRepository(Article::class);
        /** @var Article $article */
        $article=$repository->findOneBy(['slug'=> $slug]);

        if(!$article)
        {
            throw $this->createNotFoundException(sprintf('No article for slug "%s"',$slug));
        }
       

        $comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];

        
        
        return $this->render('article/show.html.twig',[
            'article'=>$article,
            'comments'=>$comments
        ]);
    }

    /**
     * @Route("news/{slug}/heart", name="article-toggle-heart",methods={"POST"})
     */

    public function toggleArticleHeart($slug)
    {
        //TODO - actually heart/unheart article
        return new JsonResponse(['hearts'=> rand(5, 100)]);
    }

}
