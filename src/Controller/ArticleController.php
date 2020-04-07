<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nexy\Slack\Client;
use Psr\Log\LoggerInterface;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ArticleController extends AbstractController
{
    /**
     * Undocumented function
     *
     * @Route("/", name="app_homepage")
     */
    public function homepage(ArticleRepository $repository)
    {
       
        $articles=$repository->findAllPublishedOrderedByNewest();
        return $this->render('article/homepage.html.twig',[
            'articles'=>$articles
        ]);
    }


    /**
     * @Route("news/{slug}", name="article_show")
     */

    public function show(Article $article, Client $slack)
    {
        if ($article->getSlug() === 'khaaaaaan') {
            $message = $slack->createMessage()
                ->from('Khan')
                ->withIcon(':ghost:')
                ->setText('Ah, Kirk, my old friend...');
            $slack->sendMessage($message);
        } 
        return $this->render('article/show.html.twig',[
            'article'=>$article,
        ]);
    }

    /**
     * @Route("news/{slug}/heart", name="article-toggle-heart",methods={"POST"})
     */

    public function toggleArticleHeart( Article $article, LoggerInterface $logger, EntityManagerInterface $em)
    {
        //TODO - actually heart/unheart article
        $article->incrementHeartCount();
        $em->flush();
        $logger->info('Article is being hearted!');
        return new JsonResponse(['hearts'=> $article->getHeartCount()]);
    }

}
