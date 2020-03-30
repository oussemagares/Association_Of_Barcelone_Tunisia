<?php

namespace BiblioBundle\Controller;

use Assetic\Filter\DartFilter;
use BiblioBundle\Entity\Events;
use Proxies\__CG__\BarceloneBundle\Entity\listeCommande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use BiblioBundle\Entity\Accesoire;
use BiblioBundle\Entity\User;
use BiblioBundle\Entity\Commande;
use BiblioBundle\Entity\Notification;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Date;


class DefaultController extends Controller
{
/**
   * @Route("/",name="simpleuser")
   */
  
    public function indexAction()
    {
        $manager = $this->getDoctrine()->getManager();
        $livres= $manager->getRepository(Accesoire::class)->findAll();
      
        return $this->render('@Biblio/home/home.html.twig',[
            "livre" => $livres
        ]);
    }

/**
   * @Route("/eror",name="eror")
   */
  
  public function eror()
  {
         
    
      return $this->render('@Biblio/home/eror.html.twig',[
        
      ]);
  }
/**
   * @Route("/emprente/{id}",name="emprenter")
   */
  
  public function emprenter( $id )
  {

      $manager = $this->getDoctrine()->getManager();
      $query = $manager->createQuery(
        'SELECT u
        FROM  BiblioBundle:User u
        WHERE u.roles LIKE :role'
    )->setParameter('role', "%ROLE_USER%");
      $bib = $query->getResult();
      $user = $this->getUser();     
      $commande= $manager->getRepository(Events::class)->find($id);
      $emprunte=new Events();
      $emprunte->setDateDebut(new \DateTime);
      $emprunte->setDateFin(new \DateTime('now + 7 days '));
      $emprunte->setTitle($commande);
      $emprunte->setUser($user);
      $commande->getNbrLimite();
      $manager->persist($emprunte);
      $manager->persist($commande);
      $manager->flush();
    return  $this->render("@Biblio/home/reserver.html.twig");
  }


  /**
 * @Route("/acheter/{id}",name="detaile")
 */

    public function detaile( $id )
    {

        $manager = $this->getDoctrine()->getManager();
        $accesoire= $manager->getRepository(Accesoire::class)->find($id);
        $cmd= $manager->getRepository(Commande::class)->findOneBy(['acces'=>$id]);
//      var_dump($cmd);
        if ($cmd ==null)
        {$userr = $this->getUser();
            $commande=new Commande();
            $commande->setuser($userr);
            $commande->setAcces($accesoire);
            $commande->setDateCommande(new \DateTime());
            $commande->setQuantite(1);
            $manager->persist($commande);
            $manager->flush();
        }
        else{
            $cmd->setQuantite($cmd->getQuantite()+1);
            $manager->persist($cmd);
            $manager->flush();
        }


        return $this->redirectToRoute("simpleuser");

    }



    /**
     * @Route("/reserver/{id}",name="reserver")
     */
    public function reserver( $id )
    {

        $manager = $this->getDoctrine()->getManager();
        $event= $manager->getRepository(Events::class)->find($id);
            $userr = $this->getUser();
            $event->setUser($userr);
            $event->setNbrLimite($event->getNbrLimite()-1);
            $manager->persist($event);
            $manager->flush();
        return $this->render("@Biblio/home/reserver.html.twig",[
            "events" => $event,"id"=>$id]);

    }



/**
   * @Route("/allevent",name="allevent")
   */
  
  public function AllEvent(  )
  {

      $manager = $this->getDoctrine()->getManager();

      $evenement= $manager->getRepository(Events::class)->findAll();
      return $this->render('@Biblio/home/allevents.html.twig',[
          "events" => $evenement
      ]);
  }

    /**
     * @Route("/macommande",name="listecommande")
     */

    public function listcommande(UserInterface $user , Request $request)
    {
        $userId = $user->getId();
        $manager = $this->getDoctrine()->getManager();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $query = $manager->createQuery(
            'SELECT e
        FROM  BiblioBundle:Commande e
        WHERE e.user = :id')->setParameter('id', $userId);
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            $request->query->getInt('limit', 5) /*limit per page*/
        );
        dump($pagination);

       return $this->render('@Biblio/user/commande.html.twig', ["com" => $pagination]);
    }

    /**
     * @Route("/confirme",name="confirme")
     */

    public function confirme()
    {
        return $this->render('@Biblio/home/confirme.html.twig');
    }

  /**
   * @Route("/recherche",name="recherche")
   */
  public function recherche(Request $request){
    $manager=$this->getDoctrine()->getManager();
   if($request->isMethod("POST"))
  {
    $variable=$request->get('variable');
    $query = $manager->createQuery(
      'SELECT l
      FROM  BiblioBundle:Events l
      WHERE l.title LIKE :id'
     )->setParameter('id',"%".$variable."%");
  }
     $com = $query->getResult();
      if ($com==null) {
        return $this->render('@Biblio/home/notfound.html.twig');
      }
      else{
        return $this->render('@Biblio/home/rechercheEvent.html.twig',[
          "event"=>$com
      ]);
      }
       
  }

}
