<?php

namespace Elton\LessonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lesson
 *
 * @author Christian Hiroz
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Elton\LessonBundle\Entity\LessonRepository")
 */
class Lesson
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
     * @ORM\Column(name="libelle", type="string", length=100)
     */
    private $libelle;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $active = 1; //means the category is active
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;
    
    /**
     * @var lessonType
     * 
     * @ORM\Column(name="type", type="lessonType")
     */
    private $type;

    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Elton\CoreBundle\Entity\File", inversedBy="lesson")
     */
    private $file;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Elton\LessonBundle\Entity\Activity", inversedBy="lessons")
     */
    private $activitys;
    
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Elton\LessonBundle\Entity\Competence")
     */
    private $competences;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Elton\LessonBundle\Entity\Category", inversedBy="lessons")
     */
    private $category;
    
    public function __construct()
    {
        $this->activitys = new \Doctrine\Common\Collections\ArrayCollection();
        $this->competences = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Lesson
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
     * Set active
     */
    public function setActive($active)
    {
        if($this->active)
        {
            $this->active = false;
           
        }
        else
        {
            $this->active = true;
        }
    }
    
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Lesson
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
     * Set type
     * 
     * @param lessonType $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
    
    /**
     * Get type
     * 
     * @return lessonType
     */
    public function getType()
    {
        return $this->type;
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
     * Set activitys
     * 
     * @param Elton\LessonBundle\Entity\Activity $activitys
     */
    public function setActivitys(\Elton\LessonBundle\Entity\Activity $activitys)
    {
        $this->activitys[] = $activitys;
    }
    
    /**
     * Remove activity
     * 
     * @param Elton\LessonBundle\Entity\Activity $activity
     */
    public function removeActivity(\Elton\LessonBundle\Entity\Activity $activity)
    {
        $this->activitys->removeElement($activity);
    }
    
    /**
     * Get file
     * 
     * @return Elton\CoreBundle\Entity\File
     */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
     * Set file
     * 
     * @param Elton\CoreBundle\Entity\File $file
     */
    public function setFile(\Elton\CoreBundle\Entity\File $file)
    {
        $this->file = $file;
    }
    
    /**
     * Get category
     * 
     * @return Elton\LessonBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
    
    /**
     * Set category
     * 
     * @param Elton\LessonBundle\Entity\Category $category
     */
    public function setCategory(\Elton\LessonBundle\Entity\Category $category)
    {
        $this->category = $category;
        $category->addLesson($this);
    }
    
    public function __toString() 
    {
        return $this->libelle;
    }
    
    /**
     * Get competences
     * 
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getCompetences()
    {
        return $this->competences;
    }
    
    /**
     * Add competence
     * 
     * @param Elton\LessonBundle\Entity\Competence $competence
     */
    public function addCompetence(\Elton\LessonBundle\Entity\Competence $competence)
    {
        $this->competences[] = $competence;
    }
    
    /**
     * Set competences
     * 
     * @param Elton\LessonBundle\Entity\Competence $competences
     */
    public function setCompetences(\Elton\LessonBundle\Entity\Competence $competences)
    {
        $this->competences[] = $competences;
    }
}
