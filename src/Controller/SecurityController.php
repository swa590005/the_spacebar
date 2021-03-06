<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use function Clue\StreamFilter\register;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception("Will be intercepted before getting here");
    }


    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $formAuthenticator)
    {

        $form= $this->createForm(UserRegistrationFormType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            /**@var User $user */
            $user= $form->getData();
            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $form['plainPassword']->getData()
            ));

            if(true === $form['agreeTerms']->getData()){
                $user->agreeTerms();
            }

            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // After we save the User to the database, 
            // we're basically going to tell Symfony to use our LoginFormAuthenticator 
            // class to authenticate the user and redirect by using its 
            // onAuthenticationSuccess() method.

            // Check it out: add two arguments to our controller. 
            // First, a service called GuardAuthenticatorHandler $guardHandler. 
            // Second, the authenticator that you want to authenticate 
            // through: LoginFormAuthenticator $formAuthenticator:

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $formAuthenticator,
                'main'
            );
            
        }

        return $this->render('security/register.html.twig',[
            'registrationForm'=> $form->createView(),
        ]);
    }


}
