<?php

namespace BiblioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Aseert ; 
use BiblioBundle\Entity\Commande;
use BiblioBundle\Entity\Notification;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="BiblioBundle\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, unique=true)
     */
    private $password;

    /**
     * @var int
     *
     * @ORM\Column(name="cin", type="integer")
     */
    private $cin;

    /**
     *
     * @ORM\Column(name="roles", type="json_array")
     */
    private $roles =[];

    /**
     * @Aseert\Length(min=6)
     * @Aseert\EqualTo(propertyPath="password" ,message="votre titre est short")
     */
    public $confirmpassorwd;

 /**
     * @var int
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;
/**
     * Set active
     *
     * @param string $active
     *
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set cin
     *
     * @param integer $cin
     *
     * @return User
     */
    public function setCin($cin)
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * Get cin
     *
     * @return int
     */
    public function getCin()
    {
        return $this->cin;
    }

    
    public function getRoles()
    {
        $roles = $this->roles;
        
        // give everyone ROLE_USER!
        if (!in_array('ROLE_USER', $roles)) {
            $roles[] = 'ROLE_USER';
        }
        return $roles;
    
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }


     /**
     * @ORM\OneToMany(targetEntity="Commande", mappedBy="user")
     */
    private $commande;

      /**
     * @ORM\OneToMany(targetEntity="Notification", mappedBy="user")
     */
    private $notification;

    /**
     * @ORM\OneToMany(targetEntity="Events", mappedBy="user")
     */
    private $event;

    public function __construct()
    {
        $this->commande = new ArrayCollection();
        $this->notification = new ArrayCollection();
        $this->event = new ArrayCollection();

    }

    /**
     * @return Collection|Events[]
     */
    public function getcommande() //: Collection
    {
        return $this->commande;
    }

     /**
     * @return Collection|Commande[]
     */
    public function getevent() //: Collection
    {
        return $this->event;
    }
  
  

    /**
     * @return Collection|Notification[]
     */
    public function getNotification() //: Collection
    {
        return $this->notification;
    }


    public function eraseCredentials(){}
        public function getSalt(){}



}

