<?php

namespace Elton\PaymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class OfferController extends Controller
{
    /**
     * @Route("/offres", name="offers")
     * @Template()
     */
    public function offersAction()
    {
        $returnArray = $this->get('elton.teacher.manager')->check();
        $em = $this->getDoctrine()->getManager();
        $offers = $em->getRepository('EltonPaymentBundle:Offer')->findAll();
        
        $returnArray['offers'] = $offers;
        
        return $returnArray;
    }
    
    /**
     * @Route("/offre/{id}", name="offer_choosed", options={"expose"=true})
     * @Template()
     */
    public function offerChoosedAction($id)
    {
        if($id != "0"){
            $session =  $this->container->get('session');
            //mise en session de l'offre
            $session->set('offerId', $id);
            
            
            return true;
        }
        
        return false;
    }
}
