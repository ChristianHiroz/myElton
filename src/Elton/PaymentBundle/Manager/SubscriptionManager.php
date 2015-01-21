<?php
/**
 * Description of OfferManager
 *
 * @author Christian Hiroz
 */


namespace Elton\PaymentBundle\Manager;

use Doctrine\ORM\EntityManager;
use Elton\CoreBundle\Manager\CoreManager as CoreManager;
use Elton\PaymentBundle\Entity\Subscription;

class SubscriptionManager extends CoreManager
{
    protected $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getRepository()
    {
        return $this->em->getRepository('EltonPaymentBundle:Subscription');
    }
    
    public function updateSubscription($subscription, $code)
    {
        if($code == 1)
        {
            $subscription->setIsPaymentValid(true);
        }
        else
        {
            $subscription->setIsPaymentValid(false);
        }
        
        $subscription->setPaymentDate(new \DateTime());
        $subscription->setPaymentType("CB");
        $subscription->setTrack($this->em->getRepository('EltonPaymentBundle:Tracking')->find(1));
        $subscription->setAmount($subscription->getOffer()->getPrice()*100);
        $subscription->setCurrency("EUR");
        
        $this->persist($subscription);
    }
    
    public function updateSubscriptionOgone(Subscription $subscription, $arrayOgone)
    {
        $subscription->setAcceptance($arrayOgone['ACCEPTANCE']);
        $subscription->setAmount($arrayOgone['AMOUNT']);
        $subscription->setBrand($arrayOgone['BRAND']);
        $subscription->setCartno($arrayOgone['CARDNO']);
        $subscription->setCurrency($arrayOgone['CURRENCY']);
        $subscription->setNcerror($arrayOgone['NCERROR']);
        $subscription->setOrderID($arrayOgone['orderID']);
        $subscription->setPAYID($arrayOgone['PAYID']);
        $subscription->setStatus($arrayOgone['STATUS']);
        
        $this->persist($subscription);
    }
}
