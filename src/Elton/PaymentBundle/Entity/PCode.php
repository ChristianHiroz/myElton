<?php

namespace Elton\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PCode
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Elton\PaymentBundle\Entity\PCodeRepository")
 */
class PCode
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
     * @ORM\Column(name="code", type="string", length=5)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="postalCode", type="string", length=5)
     */
    private $postalCode;
    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="Elton\PaymentBundle\Entity\Offer", inversedBy="codes")
     */
    private $offer;


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
     * Set code
     *
     * @param string $code
     * @return PCode
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }
    
    /**
     * Set offer
     *
     * @param Offer $offer
     * @return pcode
     */
    public function setOffer($offer)
    {
        $this->offer = $offer;
        $offer->addCode($this);

        return $this;
    }

    /**
     * Get offer
     *
     * @return Offer 
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     * @return PCode
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string 
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }
    
    public function __toString() 
    {
        $return = $this->code . " CP:   " . $this->postalCode;
        return $return;
    }
}
