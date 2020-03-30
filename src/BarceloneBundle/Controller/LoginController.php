<?php

namespace BiblioBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use BiblioBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
class LoginController extends  AbstractController
{
    /**
     * @Route("/login",name="login")
     */
    public function loginAction( AuthenticationUtils $authenticationUtils)

    {
        $error = $authenticationUtils->getLastAuthenticationError();
         $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@Biblio/Login/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

 /**
     * @Route("/register", name="register")
     */
    public function register(Request $request ,UserPasswordEncoderInterface $encoder)
    {
        $profileData = ['ROLE_USER'];
        $manager = $this->getDoctrine()->getManager();
        $user =new User();
        $form =$this->CreateFormBuilder($user)
        ->add('email')
        ->add('username')
        ->add('password')
        ->add('confirmpassorwd')
        ->add('cin')
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $hash =$encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $user->setRoleS(['ROLE_USER']);           
             $user->setActive(1);
             $manager->persist($user);
             $manager->flush();
             return $this->redirectToRoute('login');
        }
        return $this->render('@Biblio/Register/register.html.twig', [
            'form'=>$form->createView()
        ]);
    }


/**
     * @Route("/logout", name="logout")
     */ 
    public function Logout()
    {
        
    }



}
