<?php

namespace Elton\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * File
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Elton\CoreBundle\Entity\FileRepository")
 * @ORM\HasLifecycleCallbacks
 */
class File
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
     * @ORM\OneToOne(targetEntity="File")
     */
    private $ogg;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255, nullable=true)
     */
    private $alt;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="lien", type="string", length=255, nullable=true)
     */
    private $lien;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Elton\CoreBundle\Entity\Level")
     */
    private $level;
    
    private $file; 
    private $tempFilename;


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
     * Set ogg
     * 
     * @param File $ogg
     * @return File
     */
    public function setOgg($ogg)
    {
        $this->ogg = $ogg;
        
        return $this;
    }
    
    /**
     * Get ogg
     * 
     * @param File $ogg
     */
    public function getOgg()
    {
        return $this->ogg;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return File
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
     * Set lien
     *
     * @param string $lien
     * @return File
     */
    public function setLien($lien)
    {
        $this->lien = $lien;

        return $this;
    }

    /**
     * Get lien
     *
     * @return string 
     */
    public function getLien()
    {
        return $this->lien;
    }
    /**
     * Set alt
     *
     * @param string $alt
     * @return File
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt()
    {
        return $this->alt;
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
     * Set lessons
     * 
     * @param Elton\LessonBundle\Entity\Lesson $lessons
     */
    public function setLesson(\Elton\LessonBundle\Entity\Lesson $lessons)
    {
        $this->lessons = $lessons;
    }
    

    /**
     * Set file
     *
     * @param UploadedFile $file
     * @return File
     */
    public function setFile(\Symfony\Component\HttpFoundation\File\UploadedFile $file)
    {
        $this->file = $file;
        if (null !== $this->url) 
        {
            $this->tempFilename = $this->url;
            $this->url = null;
            $this->alt = null;
        }
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
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
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null === $this->file)
        {
            $this->url = "mp4" ; 
            $this->alt = $this->lien; 
            return;
        }
        $type = $this->file->guessExtension();
        $ext = $this->file->getMimeType();
        if($ext == "audio/mpeg") { $type = "mp3"; }
        else if($ext == "audio/ogg") { $type = "ogg"; }
        else if ($ext == "text/plain") { $type = "js" ; }
        else if ($ext == "application/pdf") { $type = "pdf" ; }
        else if ($ext == "inode/x-empty") { $type = "mp4" ; }
        $this->url = $type;
        
            $this->alt = $this->file->getClientOriginalName();
      }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) 
        {
            return;
        }
        if (null !== $this->tempFilename) 
        {
            $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
            if (file_exists($oldFile)) 
            {
                unlink($oldFile);
            }
        }
        $this->file->move($this->getUploadRootDir(),$this->id.'.'.$this->url);
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        $this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->url;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (file_exists($this->tempFilename)) 
        {
            unlink($this->tempFilename);
        }
    }

    public function getUploadDir()
    {
        return 'uploads/img';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    
    public function __toString() {
        return $this->alt;
    }
}
