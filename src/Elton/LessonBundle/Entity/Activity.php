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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Elton\LessonBundle\Entity\Competence")
     */
    private $competences;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="files", type="object")
     */
    private $files;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Elton\CoreBundle\Entity\File", inversedBy="lesson")
     */
    private $file;

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
     * Add competence
     * 
     * @param Elton\LessonBundle\Entity\Competence $competence
     */
    public function addActivity(\Elton\LessonBundle\Entity\Competence $competence)
    {
        $this->competences[] = $competence;
    }
    
    /**
     * Set competences
     * 
     * @param Elton\LessonBundle\Entity\Competence $competences
     */
    public function setActivitys(\Elton\LessonBundle\Entity\Competence $competences)
    {
        $this->competences[] = $competences;
    }
    
    /**
     * Remove competence
     * 
     * @param Elton\LessonBundle\Entity\Competence $competence
     */
    public function removeActivity(\Elton\LessonBundle\Entity\Competence $competence)
    {
        $this->competences->removeElement($competence);
    }
    

    /**
     * Add files
     * 
     * @param Elton\CoreBundle\Entity\File $file
     */
    public function addFile(\Elton\CoreBundle\Entity\File $file)
    {
        $this->files[] = $file;
    }
    
    /**
     * Set files
     * 
     * @param Elton\CoreBundle\Entity\File $files
     */
    public function setFiles(\Elton\CoreBundle\Entity\File $files)
    {
        $this->files[] = $files;
    }
    
    /**
     * Remove files
     * 
     * @param Elton\CoreBundle\Entity\File $file
     */
    public function removeFile(\Elton\CoreBundle\Entity\File $file)
    {
        $this->files->removeElement($file);
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
