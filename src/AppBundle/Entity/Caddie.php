<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Caddie.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CaddieRepository")
 */
class Caddie
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
     * @ORM\Column(name="session", type="string", length=255)
     */
    private $session;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="caddies")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
     * @var decimal
     *
     * @ORM\Column(name="prix", type="decimal", scale=2)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=true)
     */
    private $titre;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Menu", inversedBy="caddies")
     */
    private $menu;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Upsell", inversedBy="caddies")
     */
    private $upsell;

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
     * Set quantite.
     *
     * @param int $quantite
     *
     * @return Caddie
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite.
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set prix.
     *
     * @param string $prix
     *
     * @return Caddie
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
     * Set photo.
     *
     * @param string $photo
     *
     * @return Caddie
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
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->menus = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set user.
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Caddie
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add menus.
     *
     * @param \AppBundle\Entity\Menu $menus
     *
     * @return Caddie
     */
    public function addMenu(\AppBundle\Entity\Menu $menus)
    {
        $this->menus[] = $menus;

        return $this;
    }

    /**
     * Remove menus.
     *
     * @param \AppBundle\Entity\Menu $menus
     */
    public function removeMenu(\AppBundle\Entity\Menu $menus)
    {
        $this->menus->removeElement($menus);
    }

    /**
     * Get menus.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMenus()
    {
        return $this->menus;
    }

    /**
     * Set menu.
     *
     * @param \AppBundle\Entity\Menu $menu
     *
     * @return Caddie
     */
    public function setMenu(\AppBundle\Entity\Menu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu.
     *
     * @return \AppBundle\Entity\Menu
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Set upsell.
     *
     * @param \AppBundle\Entity\Upsell $upsell
     *
     * @return Caddie
     */
    public function setUpsell(\AppBundle\Entity\Upsell $upsell = null)
    {
        $this->upsell = $upsell;

        return $this;
    }

    /**
     * Get upsell.
     *
     * @return \AppBundle\Entity\Upsell
     */
    public function getUpsell()
    {
        return $this->upsell;
    }

    /**
     * Set titre.
     *
     * @param string $titre
     *
     * @return Caddie
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
     * Set session
     *
     * @param string $session
     *
     * @return Caddie
     */
    public function setSession($session)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session
     *
     * @return string
     */
    public function getSession()
    {
        return $this->session;
    }
}
