<?php

namespace BiblioBundle\Entity;
use BiblioBundle\Entity\User;
use BiblioBundle\Entity\Accesoire;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="BiblioBundle\Repository\CommandeRepository")
 */
class Commande
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_commande", type="date")
     */
    private $dateCommande;
    /**
     * @var string
     *
     * @ORM\Column(name="quantite", type="integer", length=255)
     */
    private $quantite;

    /**
     * @return string
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param string $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getDateCommande()
    {
        return $this->dateCommande;
    }

    /**
     * @param \DateTime $dateCommande
     */
    public function setDateCommande($dateCommande)
    {
        $this->dateCommande = $dateCommande;
    }


    /**
     * @ORM\ManyToOne(targetEntity="Accesoire", inversedBy="commande")
     */
    private $acces;

    /**
     * @return mixed
     */
    public function getAcces()
    {
        return $this->acces;
    }

    /**
     * @param mixed $acces
     */
    public function setAcces($acces)
    {
        $this->acces = $acces;
    }



 /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="commande")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    public function getuser()//: ?user
    {
        return $this->user;
    }
    public function setuser(user $user)//: self
    {
        $this->user = $user;
        return $this;
    }





}

