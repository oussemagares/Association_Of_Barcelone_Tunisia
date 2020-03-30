<?php

namespace BiblioBundle\Controller;

use BiblioBundle\Entity\Events;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use BiblioBundle\Entity\User;
use BiblioBundle\Entity\Accesoire;
use BiblioBundle\Entity\Notification;

class AdminController extends Controller
{
 /**
   * @Route("/admin",name="admin")
   */
  
   public function indexo ()
   {

    $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
    $user = $this->getUser();   
    $notif=$user->getNotification();
    return $this->render('base.admin.html.twig',[
      'notif'=>$notif
    ]);


   }
/**
   * @Route("/admin/dash",name="adashadmin")
   */
  
    public function indexAction()
    {

      $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
      $manager = $this->getDoctrine()->getManager();

        $accesoire= $manager->getRepository(Accesoire::class)->findall();

      $user = $this->getUser();   
      $notif=$user->getNotification();

      $entityManager = $this->getDoctrine()->getManager();
      $query = $entityManager->createQuery(
        'SELECT u
        FROM  BiblioBundle:User u
        WHERE u.roles LIKE :role'
    )->setParameter('role', "%ROLE_BIB_USER%");
    

    $bib = $query->getResult();
$entityManager = $this->getDoctrine()->getManager();
      $query = $entityManager->createQuery(
        'SELECT u
        FROM  BiblioBundle:User u
        WHERE u.roles LIKE :role'
    )->setParameter('role', "%ROLE_USER%");

    $user = $query->getResult();
        return $this->render('@Biblio/admin/dash.html.twig',[
          'bib'=> $bib,
          'user'=>$user,
          'notif'=>$notif,
          'acces'=>$accesoire,

        ]);
    }


  /**
   * @Route("/admin/ajout_event",name="ajoutevent")
   */
  
  public function ajoutbib(Request $request , UserPasswordEncoderInterface $encoder)
  {
    $manager = $this->getDoctrine()->getManager();
    $userr = $this->getUser();   
    $notif=$userr->getNotification();
    $event=new Events();
    //$user= new User();
    $form =$this->CreateFormBuilder($event) //$user
                ->add('title')
                ->add('date_debut')
                ->add('date_fin')
                ->add('content')
                ->add('nbr_limite')
                ->getForm();
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()){
        //$hash =$encoder->encodePassword($user,$user->getPassword());
          //$user->setPassword($hash);
          //$user->setRoleS(['ROLE_BIB_USER']);
          $manager->persist($event); //$user
          $manager->flush();
          return  $this->redirectToRoute('adashadmin');
      }

      return $this->render('@Biblio/admin/admin.ajout.event.html.twig',[
        'form'=>$form->createView(),
        'notif'=>$notif
        ]);
  }

     /**
   * @Route("/admin/list_event",name="listenvent")
   */
  
  public function listbib(Request $request)
  {
      $manager = $this->getDoctrine()->getManager();
      $user = $this->getUser();
      $notif=$user->getNotification();


      $event= $manager->getRepository(Events::class)->findall();
      return $this->render('@Biblio/admin/admin.list.event.html.twig',[
          'event'=> $event,
          'notif'=>$notif

      ]);
    }

/**
   * @Route("/admin/supp_event/{id}",name="suppevent")
   */
  
  public function supbib( $id)
  {
    $manager = $this->getDoctrine()->getManager();
    $userr = $this->getUser();   
    $notif=$userr->getNotification();
    $rep = $this->getDoctrine()->getRepository(Event::class);
    $event= $rep->find($id);
    $manager->remove($event);
    $manager->flush();
    $repr = $this->getDoctrine()->getRepository(Event::class);
    $entityManager = $this->getDoctrine()->getManager();
      $query = $entityManager->createQuery(
          'SELECT u
         FROM  BiblioBundle:Events u
         WHERE u.id > :nbr'
      )->setParameter('nbr', "0");
    
    $events = $query->getResult();
      return $this->render('@Biblio/admin/admin.list.event.html.twig',[
        'event' => $events,'notif'=>$notif
      ]);
    }

/**
   * @Route("/admin/mod_event/{id}",name="modevent")
   */
  
  public function modtbib($id,Request $request)
  {
   
    $manager = $this->getDoctrine()->getManager();
    $event= $manager->getRepository(Events::class)->find($id);
    $userr = $this->getUser();   
    $notif=$userr->getNotification();  
    if (!$event) {
      throw $this->createNotFoundException(
      'There are no event with the following id: ' . $id
      );
    }
    $form = $this->createFormBuilder($event)
    ->add('title')
    ->add('date_debut')
    ->add('date_fin')
        ->add('content')
    ->add('nbr_limite')
    ->getForm();  
    $form->handleRequest($request);
  
    if($form->isSubmitted() && $form->isValid()){
       //$hash =$encoder->encodePassword( $event, $event->getPassword());
         // $user->setPassword($hash);
          //$user->setRoles('[ROLE_BIB_USER]');
          $manager->persist($event);
          $manager->flush();
          $entityManager = $this->getDoctrine()->getManager();
          $query = $entityManager->createQuery(
              'SELECT u
         FROM  BiblioBundle:Events u
         WHERE u.id > :nbr'
          )->setParameter('nbr', "0");

        $event = $query->getResult();
      return  $this->redirectToRoute('listbib' , [
        'user' =>  $event,'notif'=>$notif
      ]);

    }
    return $this->render('@Biblio/admin/admin.update.event.html.twig',[
      'form' => $form->createView(),'notif'=>$notif
    ]);
}
/**
   * @Route("/admin/ajoutuser",name="ajoutuser")
   */
  
  public function ajoutuser(Request $request , UserPasswordEncoderInterface $encoder)
  {
    $manager = $this->getDoctrine()->getManager();
    $userr = $this->getUser();   
    $notif=$userr->getNotification();  
    $user= new User();
    $form =$this->CreateFormBuilder($user)
                ->add('email')
                ->add('username')
                ->add('password')
                ->add('cin')
                ->getForm();
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()){
        $hash =$encoder->encodePassword($user,$user->getPassword());
          $user->setPassword($hash);
          $user->setRoles(['ROLE_USER']);
          $manager->persist($user);
          $manager->flush();
          return  $this->redirectToRoute('admin',['notif'=>$notif]);
      }

      return $this->render('@Biblio/admin/adminajoutuser.html.twig',[
        'form'=>$form->createView(),'notif'=>$notif]);
  }

     /**
   * @Route("/admin/list_user",name="listuser")
   */
  
  public function listuser(Request $request)
  {
    $entityManager = $this->getDoctrine()->getManager();
    $userr = $this->getUser();   
    $notif=$userr->getNotification();  
    $query = $entityManager->createQuery(
      'SELECT u
      FROM  BiblioBundle:User u
      WHERE u.roles LIKE :role'
  )->setParameter('role', "%ROLE_USER%");
  
  $user = $query->getResult();

      return $this->render('@Biblio/admin/listuser.html.twig',[
        'user' => $user,'notif'=>$notif
      ]);
    }


     /**
   * @Route("/admin/charts",name="charts")
   */
  
  public function chart(Request $request)
  {
   
      return $this->render('@Biblio/admin/chart.html.twig');
    }






/**
   * @Route("/admin/supp_user/{id}",name="suppuser")
   */
  
  public function supuser( $id)
  {
    $manager = $this->getDoctrine()->getManager();
    $rep = $this->getDoctrine()->getRepository(User::class);
    $userr = $this->getUser();   
    $notif=$userr->getNotification();  
    $user= $rep->find($id);    
    $manager->remove($user);
    $manager->flush();
    $entityManager = $this->getDoctrine()->getManager();
    $query = $entityManager->createQuery(
      'SELECT u
      FROM  BiblioBundle:User u
      WHERE u.roles LIKE :role'
  )->setParameter('role', "%ROLE_USER%");
  
  $users = $query->getResult();
      return $this->render('@Biblio/admin/listuser.html.twig',[
        'user' => $users,'notif'=>$notif
      ]);
    }

/**
   * @Route("/admin/mod_user/{id}",name="moduser")
   */
  
  public function moduser($id,Request $request)
  {
   
    $manager = $this->getDoctrine()->getManager();
    $user= $manager->getRepository(User::class)->find($id); 
    $userr = $this->getUser();   
    $notif=$userr->getNotification();     
    if (!$user) {
      throw $this->createNotFoundException(
      'There are no user with the following id: ' . $id
      );
    }
    $form = $this->createFormBuilder($user)
    ->add('email')
    ->add('username')
    ->add('password')
    ->add('cin')
    ->getForm();  
    $form->handleRequest($request);
  
    if($form->isSubmitted() && $form->isValid()){
       $hash =$encoder->encodePassword($user,$user->getPassword());
          $user->setPassword($hash);
          $user->setRoles('[ROLE_USER]');
          $manager->persist($user);
          $manager->flush();
          $entityManager = $this->getDoctrine()->getManager();
          $query = $entityManager->createQuery(
            'SELECT u
            FROM  BiblioBundle:User u
            WHERE u.roles LIKE :role'
        )->setParameter('role', "%ROLE_USER%");
        
        $user = $query->getResult();
      return  $this->redirectToRoute('listuser' , [
        'user' => $user,'notif'=>$notif
      ]);

    }
    return $this->render('@Biblio/admin/updateuser.html.twig',[
      'form' => $form->createView(),'notif'=>$notif
    ]);
}
}
