<?php
/**
 * Description of OfferManager
 *
 * @author Christian Hiroz
 */


namespace Elton\PaymentBundle\Manager;

use Doctrine\ORM\EntityManager;
use Elton\CoreBundle\Manager\CoreManager as CoreManager;

class OfferManager extends CoreManager
{
    protected $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getRepository()
    {
        return $this->em->getRepository('EltonPaymentBundle:Offer');
    }
}
