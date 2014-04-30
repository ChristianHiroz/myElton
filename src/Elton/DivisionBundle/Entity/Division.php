<?php

namespace Elton\DivisionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as User;


/**
 * Class
 *
 * @author Christian Hiroz
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Elton\DivisionBundle\Entity\DivisionRepository")
 */
class Division
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
     * @ORM\Column(name="libelle", type="string", length=50)
     */
    private $libelle;
    
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=50)
     */
    private $username;
    
    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=50)
     */
    private $password;
    
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
     * @ORM\ManyToMany(targetEntity="Elton\LessonBundle\Entity\Competence")
     */
    private $competences;
    
    /**
     * @ORM\OneToOne(targetEntity="Elton\TeacherBundle\Entity\Cart", mappedBy="division", cascade="persist")
     */
    private $cart;

    public function __construct()
    {
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
     * @return Division
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
     * Set username
     *
     * @param string $username
     * @return Division
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
     * Set password
     *
     * @param string $password
     * @return Division
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
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
     * Get competences
     * 
     * @return Doctrine\Common\Collections\Collection
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
     * Remove competence
     * 
     * @param Elton\LessonBundle\Entity\Competence $competence
     */
    public function removeCompetence(\Elton\LessonBundle\Entity\Competence $competence)
    {
        $this->competences->removeElement($competence);
    }
}
