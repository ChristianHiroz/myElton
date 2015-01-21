<?php

namespace Elton\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Offer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Elton\PaymentBundle\Entity\OfferRepository")
 */
class Offer
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
     * @ORM\Column(name="of_nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="of_description", type="string", length=500)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="of_active", type="boolean")
     */
    private $isActive;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="of_enCours", type="boolean")
     */
    private $isEnCours;

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
     * Set nom
     *
     * @param string $nom
     * @return Offer
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Offer
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return Offer
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    
    
    /**
     * Set isEnCours
     *
     * @param boolean $isEnCours
     * @return Offer
     */
    public function setIsEnCours($isEnCours)
    {
        $this->isEnCours = $isEnCours;

        return $this;
    }

    /**
     * Get isEnCours
     *
     * @return boolean 
     */
    public function getIsEnCours()
    {
        return $this->isEnCours;
    }
}
