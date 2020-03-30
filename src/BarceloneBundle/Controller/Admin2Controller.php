<?php

namespace BiblioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use BiblioBundle\Entity\User;
use BiblioBundle\Entity\Accesoire;
use BiblioBundle\Entity\Events;
use BiblioBundle\Entity\ListeCommande;
use BiblioBundle\Entity\Commande;
use BiblioBundle\Entity\Notification;

class Admin2Controller extends Controller
{


  /**
   * @Route("/admin2",name="admin2")
   */
  
  public function index()
  {
    $manager = $this->getDoctrine()->getManager();
    $accesoire= $manager->getRepository(Accesoire::class)->findall();
    $user = $this->getUser();   
    $notif=$user->getNotification();

$entityManager = $this->getDoctrine()->getManager();
    $query = $entityManager->createQuery(
      'SELECT u
      FROM  BiblioBundle:User u
      WHERE u.roles LIKE :role'
  )->setParameter('role', "%ROLE_USER%");

  $user = $query->getResult();
      return $this->render('base.admin2.html.twig',[
        'acces'=> $accesoire,
        'user'=>$user,
        'notif'=>$notif
      ]);
  }

  /**
   * @Route("/admin2/dashbord",name="dashbord")
   */
  
  public function dash()
  {
    $manager = $this->getDoctrine()->getManager();
    $accesoire= $manager->getRepository(Accesoire::class)->findall();
    $emprente= $manager->getRepository(Commande::class)->findall();

    $user = $this->getUser();   
    $notif=$user->getNotification();

$entityManager = $this->getDoctrine()->getManager();
    $query = $entityManager->createQuery(
      'SELECT u
      FROM  BiblioBundle:User u
      WHERE u.roles LIKE :role'
  )->setParameter('role', "%ROLE_USER%");

  $user = $query->getResult();
      return $this->render('@Biblio/Admin2/admin2.html.twig',[
        'acces'=> $accesoire,
        'user'=>$user,
        'notif'=>$notif,
        'emprente'=>$emprente
      ]);
  }


  /**
   * @Route("/admin2/ajoutaccesoire",name="ajoutaccesoire")
   */
  
  public function ajoutAccesoire(Request $request )
  {
    $manager = $this->getDoctrine()->getManager();
    $user = $this->getUser();   
    $notif=$user->getNotification();

      $accesoire= new Accesoire();
    $query = $manager->createQuery(
      'SELECT u
      FROM  BiblioBundle:User u
      WHERE u.roles LIKE :role'
  )->setParameter('role', "%ROLE_ADMIN%");
    $admin = $query->getResult();

    $form =$this->CreateFormBuilder($accesoire)
                ->add('nomAccesoire')
                ->add('price')
                ->add('dateCreation')
                ->add('image')
                ->getForm();
      if($form->isSubmitted() && $form->isValid()){
          $manager->persist($accesoire);
          $manager->flush();
          return  $this->redirectToRoute('ajoutaccesoire',['notif'=>$notif]);
      }
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()){
        $query = $manager->createQuery(
          'SELECT A
          FROM  BiblioBundle:Accesoire A
          WHERE A.nomAccesoire LIKE :Accessoire'
      )->setParameter('Accessoire', "%".$accesoire->getNomAccesoire()."%");
      $bibname = $query->getResult();
         if($bibname){
          $this->addFlash(
            'notice',
            'Accesoire existe déja  !'
        );
         }
         else{
             $accesoire->setDisponible(1);
          $manager->persist($accesoire);
          $manager->flush();
          $this->addFlash(
            'ajout',
            'Accesoire ajouté !'
        );
          return  $this->redirectToRoute('ajoutaccesoire',['notif'=>$notif]);
       
      }
    }
    
      return $this->render('@Biblio/Admin2/admin2.ajout.accesoire.html.twig',[
        'form'=>$form->createView(),

        'notif'=>$notif
        ]);//'forma'=>$forma->createView(),'formaa'=>$formaa->createView(),
  }

/**
   * @Route("/admin2/list_accesoire",name="listeaccesoire")
   */
  
  public function listAccesoire()
  {

    $manager = $this->getDoctrine()->getManager();
    $user = $this->getUser();   
    $notif=$user->getNotification();


    $accesoire= $manager->getRepository(Accesoire::class)->findall();
      return $this->render('@Biblio/Admin2/admin2.list.accesoire.html.twig',[
        'accesoire'=> $accesoire,
        'notif'=>$notif
  
      ]);
  }


/**
   * @Route("/admin2/ajouteuser",name="ajoutuser")
   */
  
  public function ajoutuser(Request $request)
  {

    
    $manager = $this->getDoctrine()->getManager();
    $user = $this->getUser();   
    $notif=$user->getNotification();


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
          $user->setRoleS(['ROLE_USER']);           
          $manager->persist($user);
          $manager->flush();
          
          return  $this->redirectToRoute('listuser',['notif'=>$notif]);
      } 
      return $this->render('@Biblio/Admin2/bib.userajout.html.twig',[
        'form'=> $form->createView(),
        'notif'=>$notif

      ]);
  }
/**
   * @Route("/admin2/listuser",name="listuser")
   */
  
  public function listuser()
  {

    $entityManager = $this->getDoctrine()->getManager();
    $user = $this->getUser();   
    $notif=$user->getNotification();


    $query = $entityManager->createQuery(
      'SELECT u
      FROM  BiblioBundle:User u
      WHERE u.roles LIKE :role'
  )->setParameter('role', "%ROLE_USER%");
  
  $user = $query->getResult();

      return $this->render('@Biblio/Admin2/admin2.listuser.html.twig',[
        'user' => $user,
        'notif'=>$notif

      ]); 
  }




    /**
     * @Route("/admin2/supp_accesoire/{id}",name="suppacces")
     */

    public function SupprimerAccesoire( $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $userr = $this->getUser();
        $notif=$userr->getNotification();
        $rep = $this->getDoctrine()->getRepository(Accesoire::class);
        $acces= $rep->find($id);
        $manager->remove($acces);
        $manager->flush();
        $repr = $this->getDoctrine()->getRepository(Accesoire::class);
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'SELECT u
         FROM  BiblioBundle:Events u
         WHERE u.id > :nbr'
        )->setParameter('nbr', "0");

        $accessoir = $query->getResult();
        return $this->render('@Biblio/Admin2/admin2.list.accesoire.html.twig',[
            'acce' => $accessoir,'notif'=>$notif
        ]);
    }

    /**
     * @Route("/admin2/mod_accesoire/{id}",name="modacces")
     */

    public function ModifierAccesoire($id,Request $request)
    {

        $manager = $this->getDoctrine()->getManager();
        $accesoire= $manager->getRepository(Accesoire::class)->find($id);
        $userr = $this->getUser();
        $notif=$userr->getNotification();
        if (!$accesoire) {
            throw $this->createNotFoundException(
                'There are no accesoire with the following id: ' . $id
            );
        }
        $form = $this->CreateFormBuilder($accesoire)
            ->add('nomAccesoire')
            ->add('price')
            ->add('dateCreation')
            ->add('image')
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //$hash =$encoder->encodePassword( $event, $event->getPassword());
            // $user->setPassword($hash);
            //$user->setRoles('[ROLE_BIB_USER]');
            $manager->persist($accesoire);
            $manager->flush();
            $entityManager = $this->getDoctrine()->getManager();
            $query = $entityManager->createQuery(
                'SELECT a
         FROM  BiblioBundle:Accesoire a
         WHERE a.id > :nbr'
            )->setParameter('nbr', "0");

            $event = $query->getResult();
            return  $this->redirectToRoute('llivre' , [
                'user' =>  $event,'notif'=>$notif
            ]);

        }
        return $this->render('@Biblio/Admin2/admin2.update.accesoire.html.twig',[
            'form' => $form->createView(),'notif'=>$notif
        ]);
    }

}

