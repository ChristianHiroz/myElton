<?php

namespace Elton\LessonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activity
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Elton\LessonBundle\Entity\ActivityRepository")
 */
class Activity
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @var activityType
     * 
     * @ORM\Column(name="type", type="activityType")
     * 
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Elton\CoreBundle\Entity\File")
     */
    private $files;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Elton\CoreBundle\Entity\File")
     */
    private $file;
    
    
    public function __construct()
    {
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
     * Set name
     *
     * @param string $name
     * @return Activity
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Set description
     *
     * @param string $description
     * @return Activity
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
     * Get type
     * 
     * @return activityType
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * Set type
     * 
     * @param activityType $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
    
    /**
     * Remove competence
     * 
     * @param Elton\LessonBundle\Entity\Competence $competence
     */
    public function removeCompetence(\Elton\LessonBundle\Entity\Competence $competence)
    {
        $this->competences->removeElement($competence);
    }
    
    /**
     * Get files
     * 
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getFiles()
    {
        return $this->files;
    }
    

    /**
     * Add files
     * 
     * @param Elton\CoreBundle\Entity\File $file
     */
    public function setFiles(\Elton\CoreBundle\Entity\File $file)
    {
        $this->files = $file;
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
    
    public function __toString() 
    {
        return $this->name;
    }
}
