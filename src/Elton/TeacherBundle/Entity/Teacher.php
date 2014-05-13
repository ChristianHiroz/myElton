<?php

namespace Elton\TeacherBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as User;

/**
 * Teacher
 * 
 * @author Christian Hiroz
 * @ORM\Table(name="Teacher")
 * @ORM\Entity(repositoryClass="Elton\TeacherBundle\Entity\TeacherRepository")
 */
class Teacher extends User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="firstName", type="string", length=100)
     */
    private $firstName;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="postalCode", type="string", length=5)
     */
    private $postalCode;
    
    /**
     * @ORM\OneToMany(targetEntity="Elton\TeacherBundle\Entity\Cart", mappedBy="teacher", cascade={"remove"})
     */
    private $carts;
    
    /**
     * @ORM\OneToMany(targetEntity="Elton\DivisionBundle\Entity\Division", mappedBy="teacher", cascade={"remove"})
     */
    private $divisions;
    
    public function __construct()
    {
        parent::__construct();
        $this->carts = new \Doctrine\Common\Collections\ArrayCollection();     
        $this->divisions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get carts
     * 
     * @return Doctrine\Common\Collections\Collection
     */
    public function getCarts()
    {
        return $this->carts;
    }
    
    /**
     * Get name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set name
     * 
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Get firstName
     * 
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
    
    /**
     * Set firstName
     * 
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
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
    
    /**
     * Set postalCode
     * 
     * @param string $postalCode
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }
    
    /**
     * Add division
     * 
     * @param Elton\DivisionBundle\Entity\Division $division
     */
    public function addDivision(\Elton\DivisionBundle\Entity\Division $division)
    {
        $this->divisions[] = $division;
        $division->setTeacher($this);
    }
    
    /**
     * Remove division
     * 
     * @param Elton\DivisionBundle\Entity\Division $division
     */
    public function removeDivision(\Elton\DivisionBundle\Entity\Division $division)
    {
        $this->divisions->removeElement($division);
    }
    
    /**
     * Get divisions
     * 
     * @return Doctrine\Common\Collections\Collection
     */
    public function getDivisions()
    {
        return $this->divisions;
    }
    
    /**
     * Add cart
     * 
     * @param Elton\TeacherBundle\Entity\Cart $cart
     */
    public function addCart(\Elton\TeacherBundle\Entity\Cart $cart)
    {
        $this->carts[] = $cart;
        $cart->setTeacher($this);
    }
    
    /**
     * Remove cart
     * 
     * @param Elton\TeacherBundle\Entity\Cart $cart
     */
    public function removeCart(\Elton\TeacherBundle\Entity\Cart $cart)
    {
        $this->carts->removeElement($cart);
    }
    
    /**
     * toString
     */
    public function __toString() {
        return $this->username;
    }
}
