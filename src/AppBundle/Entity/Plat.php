<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plat
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PlatRepository")
 */
class Plat
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="accroche", type="string", length=255)
     */
    private $accroche;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="temps", type="string", length=25)
     */
    private $temps;

    /**
     * @var string
     *
     * @ORM\Column(name="difficulte", type="string", length=25)
     */
    private $difficulte;

    /**
     * @var string
     *
     * @ORM\Column(name="consistance", type="string", length=50)
     */
    private $consistance;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="text")
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="plus", type="text")
     */
    private $plus;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Menu", mappedBy="plats", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $menus;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Plat
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set accroche
     *
     * @param string $accroche
     * @return Plat
     */
    public function setAccroche($accroche)
    {
        $this->accroche = $accroche;

        return $this;
    }

    /**
     * Get accroche
     *
     * @return string 
     */
    public function getAccroche()
    {
        return $this->accroche;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Plat
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set temps
     *
     * @param string $temps
     * @return Plat
     */
    public function setTemps($temps)
    {
        $this->temps = $temps;

        return $this;
    }

    /**
     * Get temps
     *
     * @return string 
     */
    public function getTemps()
    {
        return $this->temps;
    }

    /**
     * Set difficulte
     *
     * @param string $difficulte
     * @return Plat
     */
    public function setDifficulte($difficulte)
    {
        $this->difficulte = $difficulte;

        return $this;
    }

    /**
     * Get difficulte
     *
     * @return string 
     */
    public function getDifficulte()
    {
        return $this->difficulte;
    }

    /**
     * Set consistance
     *
     * @param string $consistance
     * @return Plat
     */
    public function setConsistance($consistance)
    {
        $this->consistance = $consistance;

        return $this;
    }

    /**
     * Get consistance
     *
     * @return string 
     */
    public function getConsistance()
    {
        return $this->consistance;
    }

    /**
     * Set photo
     *
     * @param string $photo
     * @return Plat
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set plus
     *
     * @param string $plus
     * @return Plat
     */
    public function setPlus($plus)
    {
        $this->plus = $plus;

        return $this;
    }

    /**
     * Get plus
     *
     * @return string 
     */
    public function getPlus()
    {
        return $this->plus;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->menus = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add menus
     *
     * @param \AppBundle\Entity\Menu $menus
     * @return Plat
     */
    public function addMenu(\AppBundle\Entity\Menu $menus)
    {
        $this->menus[] = $menus;

        return $this;
    }

    /**
     * Remove menus
     *
     * @param \AppBundle\Entity\Menu $menus
     */
    public function removeMenu(\AppBundle\Entity\Menu $menus)
    {
        $this->menus->removeElement($menus);
    }

    /**
     * Get menus
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMenus()
    {
        return $this->menus;
    }
}
