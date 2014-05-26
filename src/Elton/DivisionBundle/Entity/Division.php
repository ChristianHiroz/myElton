<?php

namespace Elton\DivisionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;
use FOS\UserBundle\Model\User;

/**
 * Class
 *
 * @author Christian Hiroz
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Elton\DivisionBundle\Entity\DivisionRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Division extends User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=10)
     */
    private $libelle;
    
    /**
     * @var boolean
     * 
     * @ORM\Column(name="selected", type="boolean")
     */
    private $selected; //mean this is the division selected by the teacher in his divisions list

    /**
     *
     * @ORM\ManyToOne(targetEntity="Elton\TeacherBundle\Entity\Teacher", inversedBy="carts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $teacher;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Elton\CoreBundle\Entity\Level")
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;
    
    /**
     * @ORM\ManyToMany(targetEntity="Elton\LessonBundle\Entity\Competance")
     */
    private $competances;
    
    /**
     * @ORM\OneToOne(targetEntity="Elton\TeacherBundle\Entity\Cart", mappedBy="division", cascade="persist")
     */
    private $cart;

    public function __construct()
    {
        parent::__construct();
        $this->competances = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Division
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }
    
    public function setUserName($username)
    {
        $this->email = $username;
        $this->username = $username; 
    }
    
    public function setUsernameCanonical($usernameCanonical)
    {
        $this->emailCanonical = $usernameCanonical;
        $this->usernameCanonical = $usernameCanonical; 
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
     * Get cart
     * 
     * @return Elton\TeacherBundle\Entity\Cart
     */
    public function getCart()
    {
        return $this->cart;
    }
    
    /**
     * Set cart
     * 
     * @param Elton\TeacherBundle\Entity\Cart $cart
     */
    public function setCart(\Elton\TeacherBundle\Entity\Cart $cart)
    {
        $this->cart = $cart;
        $cart->setDivision($this);
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
     * Get competances
     * 
     * @return Doctrine\Common\Collections\Collection
     */
    public function getCompetances()
    {
        return $this->competances;
    }
    
    /**
     * Add competance
     * 
     * @param Elton\LessonBundle\Entity\Competance $competance
     */
    public function addCompetance(\Elton\LessonBundle\Entity\Competance $competance)
    {
        $this->competances[] = $competance;
    }
    
    /**
     * Remove competance
     * 
     * @param Elton\LessonBundle\Entity\Competance $competance
     */
    public function removeCompetance(\Elton\LessonBundle\Entity\Competance $competance)
    {
        $this->competances->removeElement($competance);
    }
    
    /**
     * Get selected
     * 
     * @return boolean
     */
    public function isSelected()
    {
        return $this->selected;
    }
    
    /**
     * Set selected
     * 
     * @param boolean $selected
     */
    public function setSelected($selected)
    {
       $this->selected = $selected;  
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function prePersist(LifecycleEventArgs $event)
    {
        $selected = $event->getEntityManager()->getRepository( get_class($this) )->getSelectedDivisionByTeacherId($this->getTeacher()->getId());
        if($selected == null)
        {
            $this->selected = true;
        }
        else
        {
            $this->selected = false;
        }
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function deSelected(LifecycleEventArgs $event)
    {
        if($this->selected == true)
        {
            $divisions = $event->getEntityManager()->getRepository( get_class($this) )->getNotSelectedDivisionByTeacherId($this->getTeacher()->getId());
            if($divisions != null)
            {
                $divisions[0]->setSelected(true);
                $event->getEntityManager()->persist($divisions[0]);
                $event->getEntityManager()->flush();
            }
        }
    }
}
