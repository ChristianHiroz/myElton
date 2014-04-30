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
     *
     * @ORM\ManyToOne(targetEntity="Elton\CoreBundle\Entity\Level")
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="Elton\LessonBundle\Entity\Lesson", mappedBy="category")
     */
    private $lessons;


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
     * Set lessons
     *
     * @param Elton\LessonBundle\Entity\Lesson $lessons
     */
    public function setLessons(\Elton\LessonBundle\Entity\Lesson $lessons)
    {
        $this->lessons = $lessons;
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
}
