<?php

namespace Elton\TeacherBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cart
 * 
 * @ORM\Entity(repositoryClass="Elton\TeacherBundle\Entity\CartActivityRepository")
 */
class CartActivity
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Elton\TeacherBundle\Entity\Cart")
     */
    private $cart;
    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Elton\LessonBundle\Entity\Activity")
     */
    private $activity;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $setted; //means the activity is setted to the division
    
    public function __construct() 
    {
        $this->setted = false;
    }
    
    public function setActivity(\Elton\LessonBundle\Entity\Activity $activity)
    {
        $this->activity = $activity;
    }
    
    public function getActivity()
    {
        return $this->activity;
    }
    
    public function setCart(\Elton\TeacherBundle\Entity\Cart $cart)
    {
        $this->cart = $cart;
        $cart->addActivity($this);
    }
    
    public function getCart()
    {
        return $this->cart;
    }
    
    public function setSetted()
    {
        if($this->setted)
        {
            $this->setted=false;
           
        }
        else
        {
            $this->setted = true;
        }
    }
    
    public function isSetted()
    {
        return $this->setted;
    }
}