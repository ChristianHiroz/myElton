<?php

namespace Elton\TeacherBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;
use Elton\CoreBundle\Entity\User as User;

/**
 * Teacher
 * 
 * @author Christian Hiroz
 * @ORM\Table(name="Teacher")
 * @ORM\Entity(repositoryClass="Elton\TeacherBundle\Entity\TeacherRepository")
 * @UniqueEntity(fields = "username", targetClass = "Elton\CoreBundle\Entity\User", message="fos_user.username.already_used")
 * @UniqueEntity(fields = "email", targetClass = "Elton\CoreBundle\Entity\User", message="fos_user.email.already_used")
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
     * @ORM\Column(name="civilite", type="string", length=100)
     */
    private $civilite;
    
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
     * @var string
     * 
     * @ORM\Column(name="ecole", type="string", length=255)
     */
    private $school;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $address;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="ville", type="string", length=100)
     */
    private $town;
    
    /**
     * @ORM\OneToMany(targetEntity="Elton\TeacherBundle\Entity\Ticket", mappedBy="user")
     */
    private $tickets;
    
    /**
     * @ORM\OneToMany(targetEntity="Elton\DivisionBundle\Entity\Division", mappedBy="teacher", cascade={"remove"})
     */
    private $divisions;
    
    /**
     * @ORM\ManyToOne(targetEntity="Elton\PaymentBundle\Entity\Offer", cascade={"persist"})
     */
    private $offer;
    
    public function __construct()
    {
        parent::__construct();
        $this->divisions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->roles = array('ROLE_TEACHER', 'ROLE_USER');
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
     * Get civilite
     * 
     * @return string
     */
    public function getCivilite()
    {
        return $this->civilite;
    }
    
    /**
     * Set civilite
     * 
     * @param string $civilite
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;
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
     * Get school
     * 
     * @return string
     */
    public function getSchool()
    {
        return $this->school;
    }
    
    /**
     * Set school
     * 
     * @param string $school
     */
    public function setSchool($school)
    {
        $this->school = $school;
    }
    
    /**
     * Get address
     * 
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }
    
    /**
     * Set address
     * 
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }
    
    /**
     * Get town
     * 
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }
    
    /**
     * Set town
     * 
     * @param string $town
     */
    public function setTown($town)
    {
        $this->town = $town;
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
     * Add ticket
     * 
     * @param Elton\TeacherBundle\Entity\Ticket $ticket
     */
    public function addTicket(\Elton\TeacherBundle\Entity\Ticket $ticket)
    {
        $this->tickets[] = $ticket;
        $ticket->setUser($this);
    }
    
    /**
     * Remove ticket
     * 
     * @param Elton\TeacherBundle\Entity\Ticket $ticket
     */
    public function removeTicket(\Elton\TeacherBundle\Entity\Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }
    
    /**
     * Get tickets
     * 
     * @return Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
    }
    
    /**
     * Get offer
     * 
     * @return offer
     */
    public function getOffer()
    {
        return $this->offer;
    }
    
    /**
     * Set offer
     * 
     * @param offer $offer
     */
    public function setOffer($offer)
    {
        $this->offer = $offer;
    }
    
    /**
     * toString
     */
    public function __toString() {
        return $this->username;
    }
}
