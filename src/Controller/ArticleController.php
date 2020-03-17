<?php

namespace App\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ArticleController
{
    /**
     * Undocumented function
     *
     * @Route("/")
     */
    public function homepage()
    {
        return new Response("my front page content");
    }

    public function show()
    {
        
    }

}
