<?php

namespace Elton\TeacherBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cart
 * 
 * @author Christian Hiroz
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Elton\TeacherBundle\Entity\CartRepository")
 */
class Cart
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
     * @ORM\OneToOne(targetEntity="Elton\DivisionBundle\Entity\Division", inversedBy="cart", cascade="remove")
     */
    private $division;
    
    /**
     * @ORM\OneToMany(targetEntity="Elton\TeacherBundle\Entity\CartActivity", mappedBy="cart")
     */
    private $activitys;
    
    public function __construct()
    {
        $this->activitys = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Get division
     * 
     * @return Elton\DivisionBundle\Entity\Division
     */
    public function getDivision()
    {
        return $this->division;
    }
    
    /**
     * Set division
     * 
     * @param Elton\DivisionBundle\Entity\Division $division
     */
    public function setDivision(\Elton\DivisionBundle\Entity\Division $division)
    {
        $this->division = $division;
    }
    
    /**
     * Get activitys
     * 
     * @return Doctrine\Common\Collections\Collection
     */
    public function getActivitys()
    {
        return $this->activitys;
    }
    
    /**
     * Add activity
     * 
     * @param Elton\TeacherBundle\Entity\CartActivity $activity
     */
    public function addActivity(\Elton\TeacherBundle\Entity\CartActivity $activity)
    {
        $this->activitys[] = $activity;
    }
    
    /**
     * Empty cart
     */
    public function setEmpty()
    {
        $this->activitys = new \Doctrine\Common\Collections\ArrayCollection();
    }
             
}
