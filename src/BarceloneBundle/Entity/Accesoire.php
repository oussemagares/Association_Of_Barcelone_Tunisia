<?php

namespace BiblioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BiblioBundle\Entity\Events;
use BiblioBundle\Entity\ListeCommande;
use BiblioBundle\Entity\Commande;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
/**
 * Accesoire
 *
 * @ORM\Table(name="accesoire")
 * @ORM\Entity(repositoryClass="BiblioBundle\Repository\AccesoireRepository")
 */
class Accesoire
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
     * @ORM\Column(name="nom_accesoire", type="string", length=255)
     */
    private $nomAccesoire;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="integer", length=255)
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="date")
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="disponible", type="integer")
     */
    private $disponible;

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
     * @return string
     */
    public function getNomAccesoire()
    {
        return $this->nomAccesoire;
    }

    /**
     * @param string $nomAccesoire
     */
    public function setNomAccesoire($nomAccesoire)
    {
        $this->nomAccesoire = $nomAccesoire;
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param \DateTime $dateCreation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getDisponible()
    {
        return $this->disponible;
    }

    /**
     * @param int $disponible
     */
    public function setDisponible($disponible)
    {
        $this->disponible = $disponible;
    }




// /**
//     * @ORM\ManyToOne(targetEntity="ListeCommande", inversedBy="livre")
//     * @ORM\JoinColumn(name="genre_id", referencedColumnName="id")
//     */
//    private $genre;
//
//    public function getgenre() //: ?genre
//    {
//        return $this->genre;
//    }
//    public function setgenre(ListeCommande $genre) //: self
//    {
//        $this->genre = $genre;
//        return $this;
//    }
//
// /**
//     * @ORM\ManyToOne(targetEntity="Events", inversedBy="livre")
//     * @ORM\JoinColumn(name="auteur_id", referencedColumnName="id")
//     */
//    private $auteur;
//
//    public function getauteur()//: ?auteur
//    {
//        return $this->auteur;
//    }
//    public function setauteur(auteur $auteur) //: self
//    {
//        $this->auteur = $auteur;
//        return $this;
//    }

///**
//     * @ORM\OneToMany(targetEntity="ListeCommande", mappedBy="nomAccesoire")
//     */
//    private $commande;
//
//    public function __construct()
//    {
//        $this->commande = new ArrayCollection();
//    }
//     /**
//     * @return Collection|Commande[]
//     */
//    public function getcommande() //: Collection
//    {
//        return $this->commande;
//    }
    /**
     * @ORM\OneToMany(targetEntity="Commande", mappedBy="acces")
     * @ORM\JoinColumn(name="commande_id", referencedColumnName="id")
     */
    private $commande;

    /**
     * @return mixed
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * @param mixed $commande
     */
    public function setCommande($commande)
    {
        $this->commande = $commande;
    }



//    public function __construct()
//    {
//        $this->commande = new ArrayCollection();
//    }
//    /**
//     * @return Collection|Commande[]
//     */
//    public function getcommande() //: Collection
//    {
//        return $this->commande;
//    }






}

