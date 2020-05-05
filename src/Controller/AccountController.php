<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

// this page to be seen by all logged in user
/**
 * @isGranted("ROLE_USER")
 */
class AccountController extends BaseController
{
    /**
     * @Route("/account", name="app_account")
     */
    public function index()
    {
        
        return $this->render('account/index.html.twig', [
            
        ]);
    }
    /**
     * @Route("/api/account", name="api_account")
     */
    //just need to tell the json() method to only serialize properties that are 
    //in the group called "main". To do that, pass the normal 200 status code as 
    //the second argument, we don't need any custom headers, but we do want to pass 
    //one item to "context". Set groups => an array with the string main
    public function accountApi()
    {
        $user=$this->getUser();
        return $this->json($user, 200, [],[
            'groups'=>['main']
        ]);
    }  
}
