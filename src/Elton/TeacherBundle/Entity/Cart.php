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
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Elton\TeacherBundle\Entity\Teacher", inversedBy="carts")
     */
    private $teacher;
    
    /**
     * 
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Elton\DivisionBundle\Entity\Division", inversedBy="cart")
     */
    private $division;
    
    /**
     * @var boolean
     *
     * @ORM\Id
     * @ORM\Column(name="attribuer", type="boolean")
     */
    private $settedToDivision; //mean this is the cart setted to the division
    
    /**
     * @ORM\Column(name="activity", type="array")
     * @ORM\ManyToMany(targetEntity="Elton\LessonBundle\Entity\Activity")
     */
    private $activitys;
    
    public function __construct()
    {
        $this->activitys = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get settedToDivision
     * 
     * @return boolean
     */
    public function isSettedToDivision()
    {
        return $this->settedToDivision;
    }
    
    /**
     * Set settedToDivision
     * 
     * @param boolean $settedToDivision
     */
    public function setSettedToDivision($settedToDivision)
    {
      $this->settedToDivision = $settedToDivision;  
    }
    
    /**
     * Get teacher
     * 
     * @return Elton\TeacherBundle\Entity\Teacher
     */
    public function getTeacher()
    {
        return $this->teacher;
    }
    
    /**
     * Set teacher
     * 
     * @param Elton\TeacherBundle\Entity\Teacher $teacher
     */
    public function setTeacher(\Elton\TeacherBundle\Entity\Teacher $teacher)
    {
        $this->teacher = $teacher;
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
     * @param Elton\LessonBundle\Entity\Activity $activity
     */
    public function addActivity(\Elton\LessonBundle\Entity\Activity $activity)
    {
        $this->activitys[] = $activity;
    }
    
    /**
     * Remove activity
     * 
     * @param Elton\LessonBundle\Entity\Activity $activity
     */
    public function removeLesson(\Elton\LessonBundle\Entity\Activity $activity)
    {
        $this->activitys->removeElement($activity);
    }
}
