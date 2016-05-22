<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Upsell.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UpsellRepository")
 */
class Upsell
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var decimal
     *
     * @ORM\Column(name="prix", type="decimal", scale=2)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="origine", type="string", length=255)
     */
    private $origine;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="text")
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="departement", type="text")
     */
    private $departement;

    /**
     * @var string
     *
     * @ORM\Column(name="contenance", type="string", length=50)
     */
    private $contenance;

    /**
     * @var string
     *
     * @ORM\Column(name="actif", type="string", length=255)
     */
    private $actif;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Categorie", inversedBy="upsells")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Caddie", mappedBy="upsell", cascade={"persist"})
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
     * @return Upsell
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
     * Set description.
     *
     * @param string $description
     *
     * @return Upsell
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set prix.
     *
     * @param string $prix
     *
     * @return Upsell
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
     * Set origine.
     *
     * @param string $origine
     *
     * @return Upsell
     */
    public function setOrigine($origine)
    {
        $this->origine = $origine;

        return $this;
    }

    /**
     * Get origine.
     *
     * @return string
     */
    public function getOrigine()
    {
        return $this->origine;
    }

    /**
     * Set photo.
     *
     * @param string $photo
     *
     * @return Upsell
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
     * Set departement.
     *
     * @param string $departement
     *
     * @return Upsell
     */
    public function setDepartement($departement)
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * Get departement.
     *
     * @return string
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * Set contenance.
     *
     * @param string $contenance
     *
     * @return Upsell
     */
    public function setContenance($contenance)
    {
        $this->contenance = $contenance;

        return $this;
    }

    /**
     * Get contenance.
     *
     * @return string
     */
    public function getContenance()
    {
        return $this->contenance;
    }

    /**
     * Set actif.
     *
     * @param string $actif
     *
     * @return Upsell
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif.
     *
     * @return string
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Set categorie.
     *
     * @param \AppBundle\Entity\Categorie $categorie
     *
     * @return Upsell
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
        $this->caddies = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add caddies.
     *
     * @param \AppBundle\Entity\Caddie $caddies
     *
     * @return Upsell
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
}
