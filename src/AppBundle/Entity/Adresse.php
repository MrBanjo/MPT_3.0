<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adresse.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdresseRepository")
 */
class Adresse
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="adresses")
     * @ORM\JoinColumn(nullable=false, name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="voie", type="text")
     */
    private $voie;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=50)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="postal", type="string", length=255)
     */
    private $postal;

    /**
     * @var string
     *
     * @ORM\Column(name="complement", type="text", nullable=true)
     */
    private $complement;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

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
     * Set voie.
     *
     * @param string $voie
     *
     * @return Adresse
     */
    public function setVoie($voie)
    {
        $this->voie = $voie;

        return $this;
    }

    /**
     * Get voie.
     *
     * @return string
     */
    public function getVoie()
    {
        return $this->voie;
    }

    /**
     * Set ville.
     *
     * @param string $ville
     *
     * @return Adresse
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville.
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set postal.
     *
     * @param string $postal
     *
     * @return Adresse
     */
    public function setPostal($postal)
    {
        $this->postal = $postal;

        return $this;
    }

    /**
     * Get postal.
     *
     * @return string
     */
    public function getPostal()
    {
        return $this->postal;
    }

    /**
     * Set complement.
     *
     * @param string $complement
     *
     * @return Adresse
     */
    public function setComplement($complement)
    {
        $this->complement = $complement;

        return $this;
    }

    /**
     * Get complement.
     *
     * @return string
     */
    public function getComplement()
    {
        return $this->complement;
    }

    /**
     * Set user.
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Adresse
     */
    public function setUser(\AppBundle\Entity\User $user)
    {
        $this->user = $user;
        $this->user_id = $user->getId();

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
     * Set user_id.
     *
     * @param int $userId
     *
     * @throws \Exception
     */
    public function setUserId($userId)
    {
        throw new \Exception('Post->userId can not be set directly');
    }

    /**
     * Set titre.
     *
     * @param string $titre
     *
     * @return Adresse
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
}
