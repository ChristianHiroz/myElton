<?php

namespace Elton\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subscription
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Subscription
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
     * @var \stdClass
     *
     * @ORM\Column(name="teacher", type="object")
     */
    private $teacher;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="offer", type="object")
     */
    private $offer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="subscriptionDate", type="datetime")
     */
    private $subscriptionDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isPaymentValid", type="boolean")
     */
    private $isPaymentValid;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="paymentDate", type="datetime")
     */
    private $paymentDate;

    /**
     * @var string
     *
     * @ORM\Column(name="paymentType", type="string", length=2)
     */
    private $paymentType;

    /**
     * @var string
     *
     * @ORM\Column(name="track", type="string", length=255)
     */
    private $track;

    /**
     * @var string
     *
     * @ORM\Column(name="acceptance", type="string", length=255)
     */
    private $acceptance;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="brand", type="string", length=255)
     */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(name="cartno", type="string", length=255)
     */
    private $cartno;

    /**
     * @var string
     *
     * @ORM\Column(name="cn", type="string", length=255)
     */
    private $cn;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=255)
     */
    private $currency;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ed", type="datetime")
     */
    private $ed;

    /**
     * @var string
     *
     * @ORM\Column(name="ncerror", type="string", length=255)
     */
    private $ncerror;

    /**
     * @var string
     *
     * @ORM\Column(name="orderID", type="string", length=255)
     */
    private $orderID;

    /**
     * @var string
     *
     * @ORM\Column(name="PAYID", type="string", length=255)
     */
    private $pAYID;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;


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
     * Set teacher
     *
     * @param \stdClass $teacher
     * @return Subscription
     */
    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \stdClass 
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Set offer
     *
     * @param \stdClass $offer
     * @return Subscription
     */
    public function setOffer($offer)
    {
        $this->offer = $offer;

        return $this;
    }

    /**
     * Get offer
     *
     * @return \stdClass 
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * Set subscriptionDate
     *
     * @param \DateTime $subscriptionDate
     * @return Subscription
     */
    public function setSubscriptionDate($subscriptionDate)
    {
        $this->subscriptionDate = $subscriptionDate;

        return $this;
    }

    /**
     * Get subscriptionDate
     *
     * @return \DateTime 
     */
    public function getSubscriptionDate()
    {
        return $this->subscriptionDate;
    }

    /**
     * Set isPaymentValid
     *
     * @param boolean $isPaymentValid
     * @return Subscription
     */
    public function setIsPaymentValid($isPaymentValid)
    {
        $this->isPaymentValid = $isPaymentValid;

        return $this;
    }

    /**
     * Get isPaymentValid
     *
     * @return boolean 
     */
    public function getIsPaymentValid()
    {
        return $this->isPaymentValid;
    }

    /**
     * Set paymentDate
     *
     * @param \DateTime $paymentDate
     * @return Subscription
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    /**
     * Get paymentDate
     *
     * @return \DateTime 
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * Set paymentType
     *
     * @param string $paymentType
     * @return Subscription
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * Get paymentType
     *
     * @return string 
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * Set track
     *
     * @param string $track
     * @return Subscription
     */
    public function setTrack($track)
    {
        $this->track = $track;

        return $this;
    }

    /**
     * Get track
     *
     * @return string 
     */
    public function getTrack()
    {
        return $this->track;
    }

    /**
     * Set acceptance
     *
     * @param string $acceptance
     * @return Subscription
     */
    public function setAcceptance($acceptance)
    {
        $this->acceptance = $acceptance;

        return $this;
    }

    /**
     * Get acceptance
     *
     * @return string 
     */
    public function getAcceptance()
    {
        return $this->acceptance;
    }

    /**
     * Set amount
     *
     * @param float $amount
     * @return Subscription
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set brand
     *
     * @param string $brand
     * @return Subscription
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string 
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set cartno
     *
     * @param string $cartno
     * @return Subscription
     */
    public function setCartno($cartno)
    {
        $this->cartno = $cartno;

        return $this;
    }

    /**
     * Get cartno
     *
     * @return string 
     */
    public function getCartno()
    {
        return $this->cartno;
    }

    /**
     * Set cn
     *
     * @param string $cn
     * @return Subscription
     */
    public function setCn($cn)
    {
        $this->cn = $cn;

        return $this;
    }

    /**
     * Get cn
     *
     * @return string 
     */
    public function getCn()
    {
        return $this->cn;
    }

    /**
     * Set currency
     *
     * @param string $currency
     * @return Subscription
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string 
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set ed
     *
     * @param \DateTime $ed
     * @return Subscription
     */
    public function setEd($ed)
    {
        $this->ed = $ed;

        return $this;
    }

    /**
     * Get ed
     *
     * @return \DateTime 
     */
    public function getEd()
    {
        return $this->ed;
    }

    /**
     * Set ncerror
     *
     * @param string $ncerror
     * @return Subscription
     */
    public function setNcerror($ncerror)
    {
        $this->ncerror = $ncerror;

        return $this;
    }

    /**
     * Get ncerror
     *
     * @return string 
     */
    public function getNcerror()
    {
        return $this->ncerror;
    }

    /**
     * Set orderID
     *
     * @param string $orderID
     * @return Subscription
     */
    public function setOrderID($orderID)
    {
        $this->orderID = $orderID;

        return $this;
    }

    /**
     * Get orderID
     *
     * @return string 
     */
    public function getOrderID()
    {
        return $this->orderID;
    }

    /**
     * Set pAYID
     *
     * @param string $pAYID
     * @return Subscription
     */
    public function setPAYID($pAYID)
    {
        $this->pAYID = $pAYID;

        return $this;
    }

    /**
     * Get pAYID
     *
     * @return string 
     */
    public function getPAYID()
    {
        return $this->pAYID;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Subscription
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }
}
