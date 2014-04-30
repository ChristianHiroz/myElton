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
     * @ORM\ManyToMany(targetEntity="Elton\CoreBundle\Entity\File")
     */
    private $files;
    

    /**
     * @ORM\ManyToMany(targetEntity="Elton\LessonBundle\Entity\Competence")
     */
    private $competences;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Elton\CoreBundle\Entity\Level")
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Elton\LessonBundle\Entity\Category", inversedBy="lessons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;
    
    public function __construct()
    {
        $this->competences = new \Doctrine\Common\Collections\ArrayCollection();
        $this->files = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get files
     * 
     * @return Doctrine\Common\Collections\Collection
     */
    public function getFiles()
    {
        return $this->files;
    }
    
    /**
     * Add file
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
     * Remove file
     * 
     * @param Elton\CoreBundle\Entity\File $file
     */
    public function removeFile(\Elton\CoreBundle\Entity\File $file)
    {
        $this->files->removeElement($file);
    }
    
    /**
     * Get competences
     * 
     * @return Doctrine\Common\Collections\Collection
     */
    public function getCompetences()
    {
        return $this->competences;
    }
    
    /**
     * Add competences
     * 
     * @param Elton\LessonBundle\Entity\Competence $competences
     */
    public function setCompetences(\Elton\LessonBundle\Entity\Competence $competences)
    {
        $this->competences[] = $competences;
    }
    
    /**
     * Set competence
     * 
     * @param Elton\LessonBundle\Entity\Competence $competence
     */
    public function addCompetence(\Elton\LessonBundle\Entity\Competence $competence)
    {
        $this->competences[] = $competence;
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
    }
}
