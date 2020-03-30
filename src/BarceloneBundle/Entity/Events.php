<?php

namespace BiblioBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use BiblioBundle\Entity\Accesoire;

/**
 * Events
 *
 * @ORM\Table(name="events")
 * @ORM\Entity(repositoryClass="BiblioBundle\Repository\EventsRepository")
 */
class Events
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date")
     */
    private $date_debut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date")
     */
    private $date_fin;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", length=255)
     */
    private $nbr_limite;

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->date_debut;
    }

    /**
     * @param \DateTime $date_debut
     */
    public function setDateDebut($date_debut)
    {
        $this->date_debut = $date_debut;
    }

    /**
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->date_fin;
    }

    /**
     * @param \DateTime $date_fin
     */
    public function setDateFin($date_fin)
    {
        $this->date_fin = $date_fin;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getNbrLimite()
    {
        return $this->nbr_limite;
    }

    /**
     * @param int $nbr_limite
     */
    public function setNbrLimite($nbr_limite)
    {
        $this->nbr_limite = $nbr_limite;
    }


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="event")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    public function getUser()//: ?user
    {
        return $this->user;
    }
    public function setUser(User $user)//: self
    {
        $this->user = $user;
        return $this;
    }
}

