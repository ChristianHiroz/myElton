<?php

namespace Elton\LessonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Elton\LessonBundle\Entity\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $active = 1; //means the category is active
    
    /**
     * @var color
     * 
     * @ORM\Column(name="color", type="color")
     */
    private $color;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Elton\CoreBundle\Entity\Level")
     */
    private $level;
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="Elton\LessonBundle\Entity\Lesson", mappedBy="category")
     */
    private $lessons;
    
    public function __construct()
    {
        $this->lessons = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set libelle
     *
     * @param string $libelle
     * @return Category
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }
    
    /**
     * Set color
     * 
     * @param color $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }
    
    /**
     * Get color
     * 
     * @return color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * add lesson
     *
     * @param Elton\LessonBundle\Entity\Lesson $lesson
     */
    public function addLesson(\Elton\LessonBundle\Entity\Lesson $lesson)
    {
        $this->lessons[] = $lesson;
    }
    
    /**
     * Get lessons
     *
     * @return Elton\LessonBundle\Entity\Lesson 
     */
    public function getLessons()
    {
        return $this->lessons;
    }
    
    /**
     * Get level
     * 
     * @return Elton\CoreBundle\Entity\Level
     */
    public function getLevel()
    {
        return $this->level;
    }
    
    /**
     * Set level
     * 
     * @param Elton\CoreBundle\Entity\Level $level
     */
    public function setLevel(\Elton\CoreBundle\Entity\Level $level)
    {
        $this->level = $level;
    }
    
    /**
     * Set active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }
    
    public function isActive()
    {
        return $this->active;
    }
    
    public function __toString() {
        return $this->libelle;
    }
}
