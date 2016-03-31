<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\MenuRepository")
 */
class Menu
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
     * @ORM\Column(name="titre", type="text")
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="decimal")
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="text", length=255, nullable=true)
     */
    private $photo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="active", type="string")
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Categorie", inversedBy="menus")
     * @ORM\JoinColumn(nullable=false, name="categorie_id",referencedColumnName="id")
     */
    private $categorie;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Plat", inversedBy="menus")
     * @ORM\JoinColumn(nullable=true)
     */
    private $plats;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Caddie", mappedBy="menu", cascade={"persist"})
     */
    private $caddies;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre.
     *
     * @param string $titre
     *
     * @return Menu
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre.
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set prix.
     *
     * @param string $prix
     *
     * @return Menu
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix.
     *
     * @return string
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Menu
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set categorie.
     *
     * @param \AppBundle\Entity\Categorie $categorie
     *
     * @return Menu
     */
    public function setCategorie(\AppBundle\Entity\Categorie $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie.
     *
     * @return \AppBundle\Entity\Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->plats = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add plats.
     *
     * @param \AppBundle\Entity\Plat $plats
     *
     * @return Menu
     */
    public function addPlat(\AppBundle\Entity\Plat $plats)
    {
        $plat->addMenu($this);
        $this->plats[] = $plats;

        return $this;
    }

    /**
     * Remove plats.
     *
     * @param \AppBundle\Entity\Plat $plats
     */
    public function removePlat(\AppBundle\Entity\Plat $plats)
    {
        $this->plats->removeElement($plats);
    }

    /**
     * Get plats.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlats()
    {
        return $this->plats;
    }

    /**
     * Set active.
     *
     * @param string $active
     *
     * @return Menu
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active.
     *
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set caddie.
     *
     * @param \AppBundle\Entity\Caddie $caddie
     *
     * @return Menu
     */
    public function setCaddie(\AppBundle\Entity\Caddie $caddie)
    {
        $this->caddie = $caddie;

        return $this;
    }

    /**
     * Get caddie.
     *
     * @return \AppBundle\Entity\Caddie
     */
    public function getCaddie()
    {
        return $this->caddie;
    }

    /**
     * Add caddies.
     *
     * @param \AppBundle\Entity\Caddie $caddies
     *
     * @return Menu
     */
    public function addCaddy(\AppBundle\Entity\Caddie $caddies)
    {
        $this->caddies[] = $caddies;

        return $this;
    }

    /**
     * Remove caddies.
     *
     * @param \AppBundle\Entity\Caddie $caddies
     */
    public function removeCaddy(\AppBundle\Entity\Caddie $caddies)
    {
        $this->caddies->removeElement($caddies);
    }

    /**
     * Get caddies.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCaddies()
    {
        return $this->caddies;
    }

    /**
     * Set photo.
     *
     * @param string $photo
     *
     * @return Menu
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo.
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }
}
