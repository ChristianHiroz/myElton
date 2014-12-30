<?php
/**
 * Description of PCodeManager
 *
 * @author Christian Hiroz
 */

namespace Elton\PaymentBundle\Manager;

use Doctrine\ORM\EntityManager;
use Elton\CoreBundle\Manager\CoreManager;

class PCodeManager extends CoreManager
{
    protected $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getRepository()
    {
        return $this->em->getRepository('EltonPaymentBundle:PCode');
    }
    
    
    /*
     * @return bool if $promoCode & $postalCode match
     */
    public function getPCode($promoCode, $postalCode)
    {
        $repo = $this->getRepository();
        
        $postalCodeMatch = $repo->getPCodeInSchool($promoCode, $postalCode);
        
        return $postalCodeMatch;
    }
}