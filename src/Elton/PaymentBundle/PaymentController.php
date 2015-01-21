<?php

namespace Elton\PaymentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PaymentController extends Controller
{
    
    /**
     * @Route("/paiement/1", name="accepturl")     
     * @Template("EltonPaymentBundle:Payment:accept.html.twig")
    */
    public function acceptAction()
    {
        $returnArray = $this->container->get('elton.teacher.manager')->check();
        $this->container->get('elton.subscription.manager')->updateSubscription($returnArray['user']->getSubscriptions()->last(), 1);
       
        return $returnArray;
    }
    
    /**
     * @Route("/paiement/2", name="declineurl")     
     * @Template("EltonPaymentBundle:Payment:decline.html.twig")
    */
    public function declineAction()
    {
        $returnArray = $this->container->get('elton.teacher.manager')->check();
        
        $this->container->get('elton.subscription.manager')->updateSubscription($returnArray['user']->getSubscriptions()->last(), 2);
            
        return $returnArray;
    }
    
    /**
     * @Route("/paiement/3", name="exceptionurl")     
     * @Template("EltonPaymentBundle:Payment:exception.html.twig")
    */
    public function exceptionAction()
    {
        $returnArray = $this->container->get('elton.teacher.manager')->check();
        
        $this->container->get('elton.subscription.manager')->updateSubscription($returnArray['user']->getSubscriptions()->last(), 3);
            
        return $returnArray;
    }
    
    /**
     * @Route("/paiement/4", name="cancelurl")     
     * @Template("EltonPaymentBundle:Payment:cancel.html.twig")
    */
    public function cancelAction()
    {
        $returnArray = $this->container->get('elton.teacher.manager')->check();
        
        $this->container->get('elton.subscription.manager')->updateSubscription($returnArray['user']->getSubscriptions()->last(), 4);
            
        return $returnArray;
    }

}
