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
     *
     * @ORM\ManyToOne(targetEntity="Elton\CoreBundle\Entity\File", inversedBy="lesson")
     */
    private $file;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="Elton\LessonBundle\Entity\Activity", inversedBy="lessons")
     */
    private $activitys;
    
    public function __construct()
    {
        $this->activity = new \Doctrine\Common\Collections\ArrayCollection();
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
}
