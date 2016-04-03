<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UserRepository")
 * @UniqueEntity("email")
 */
class User implements UserInterface, \Serializable
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
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=50)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Adresse", mappedBy="user", cascade={"persist", "remove"})
     */
    private $adresses;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Caddie", mappedBy="user", cascade={"persist", "remove"})
     */
    private $caddies;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Commandes", mappedBy="user", cascade={"persist", "remove"})
     */
    private $commandes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="date")
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="civilite", type="string", length=25)
     */
    private $civilite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="subscribedate", type="datetime")
     */
    private $subscribedate;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users", cascade={"persist"})
     */
    private $roles;

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }
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
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }

    /**
     * Set nom.
     *
     * @param string $nom
     *
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom.
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom.
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom.
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set password.
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
     * Set email.
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
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set birthdate.
     *
     * @param \DateTime $birthdate
     *
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate.
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set subscribedate.
     *
     * @param \DateTime $subscribedate
     *
     * @return User
     */
    public function setSubscribedate($subscribedate)
    {
        $this->subscribedate = $subscribedate;

        return $this;
    }

    /**
     * Get subscribedate.
     *
     * @return \DateTime
     */
    public function getSubscribedate()
    {
        return $this->subscribedate;
    }
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->adresses = new ArrayCollection();
        $this->subscribedate = new \datetime();
        $this->roles = new ArrayCollection();
    }

    /**
     * Add adresses.
     *
     * @param \AppBundle\Entity\Adresse $adresses
     *
     * @return User
     */
    public function addAdress(\AppBundle\Entity\Adresse $adresses)
    {
        $this->adresses[] = $adresses;
        $adresses->setUser($this);

        return $this;
    }

    /**
     * Remove adresses.
     *
     * @param \AppBundle\Entity\Adresse $adresses
     */
    public function removeAdress(\AppBundle\Entity\Adresse $adresses)
    {
        $this->adresses->removeElement($adresses);
    }

    /**
     * Get adresses.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdresses()
    {
        return $this->adresses;
    }

    /**
     * Set username.
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
     * Add roles.
     *
     * @param \AppBundle\Entity\Role $roles
     *
     * @return User
     */
    public function addRole(\AppBundle\Entity\Role $roles)
    {
        $roles->addUser($this);
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles.
     *
     * @param \AppBundle\Entity\Role $roles
     */
    public function removeRole(\AppBundle\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Set civilite.
     *
     * @param string $civilite
     *
     * @return User
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Get civilite.
     *
     * @return string
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    public function setAdresses(ArrayCollection $Adresses)
    {
        $this->Adresses = $Adresses;
        foreach ($adresses as $adresse) {
            $adresse->setUser($this);
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getId();
    }

    /**
     * Add caddies.
     *
     * @param \AppBundle\Entity\Caddie $caddies
     *
     * @return User
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
     * Add commande
     *
     * @param \AppBundle\Entity\Commandes $commande
     *
     * @return User
     */
    public function addCommande(\AppBundle\Entity\Commandes $commande)
    {
        $this->commandes[] = $commande;

        return $this;
    }

    /**
     * Remove commande
     *
     * @param \AppBundle\Entity\Commandes $commande
     */
    public function removeCommande(\AppBundle\Entity\Commandes $commande)
    {
        $this->commandes->removeElement($commande);
    }

    /**
     * Get commandes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandes()
    {
        return $this->commandes;
    }
}
