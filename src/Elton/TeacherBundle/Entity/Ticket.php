<?php

namespace Elton\TeacherBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Ticket
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Elton\TeacherBundle\Entity\TicketRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Ticket
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
     * @ORM\ManyToOne(targetEntity="Elton\TeacherBundle\Entity\TicketReason", inversedBy="id")
     */
    private $reason;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastUpdate", type="datetime")
     */
    private $lastUpdate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isSolved", type="boolean")
     */
    private $isSolved = false;

    /**
     * @ORM\ManyToOne(targetEntity="Elton\TeacherBundle\Entity\Teacher", inversedBy="tickets")
     */
    private $user;


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
     * Set reason
     *
     * @param TicketReason $reason
     * @return Ticket
     */
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get reason
     *
     * @return TicketReason 
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Ticket
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
     * Set lastUpdate
     *
     * @param \DateTime $lastUpdate
     * @return Ticket
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }

    /**
     * Get lastUpdate
     *
     * @return \DateTime 
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * Set isSolved
     *
     * @param boolean $isSolved
     * @return Ticket
     */
    public function setIsSolved($isSolved)
    {
        $this->isSolved = $isSolved;

        return $this;
    }

    /**
     * Get isSolved
     *
     * @return boolean 
     */
    public function getIsSolved()
    {
        return $this->isSolved;
    }

    /**
     * Set user
     *
     * @param Teacher $user
     * @return Ticket
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return Teacher 
     */
    public function getUser()
    {
        return $this->user;
    }
    
            
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function prePersist(LifecycleEventArgs $event)
    {
        $this->lastUpdate = new \DateTime();   
    }
}
