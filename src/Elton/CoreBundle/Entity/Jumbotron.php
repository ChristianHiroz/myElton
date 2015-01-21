<?php

namespace Elton\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jumbotron
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Jumbotron
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
    * @var integer
    *  
    * @ORM\Column(name="numcmd", type="integer")
    */ 
   private $numcmd = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=1000)
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="messageWelcome", type="string", length=1000)
     */
    private $messageWelcome;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="temp", type="string", length=4000, nullable=true)
     */
    private $temp;


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
     * Get nmcmd
     *
     * @return integer 
     */
    public function getNmcmd()
    {
        $this->numcmd++;
        return $this->numcmd;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Jumbotron
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Jumbotron
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Jumbotron
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set messageWelcome
     *
     * @param string $messageWelcome
     * @return Jumbotron
     */
    public function setMessageWelcome($messageWelcome)
    {
        $this->messageWelcome = $messageWelcome;

        return $this;
    }

    /**
     * Get messageWelcome
     *
     * @return string
     */
    public function getMessageWelcome()
    {
        return $this->messageWelcome;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Jumbotron
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set temp
     *
     * @param string $temp
     * @return Jumbotron
     */
    public function setTemp($temp)
    {
        $this->temp = $temp;

        return $this;
    }

    /**
     * Get temp
     *
     * @return string 
     */
    public function getTemp()
    {
        return $this->temp;
    }
}
