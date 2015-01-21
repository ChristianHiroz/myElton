<?php

namespace Elton\PaymentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PCodeController extends Controller
{
    /**
     * @Route("/codePromoVerif", name="code_promo_verif")     
     * @Template("EltonPaymentBundle:PCode:find.html.twig")
     */
    public function codePromoverifAction(Request $request)
    {
        $defaultData = array('message' => 'Formulaire de verification de code promo');
        $form = $this->createFormBuilder($defaultData)
            ->add('postalCode', 'text', array('attr'=> array('placeholder' => "Entrez le code postal de votre école"), 'label' => "Code postal"))
            ->add('promoCode', 'text', array('attr'=> array('placeholder' => "Entrez votre code promotionnel"), 'label' => "Code promotionnel"))
            ->add('submit', 'submit', array('label' => 'Vérifier'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) 
        {
           $data = $form->getData();
           $pCode = $this->container->get('elton.pcode.manager')->getPCode($data['promoCode'], $data['postalCode']);
           
           if(!empty($pCode))
           {            
               $session = $this->getRequest()->getSession();
               $session->start();
               
               if($pCode[0]->getOffer()->isEnCours() && $pCode[0]->getOffer()->isActive()){
                return $this->redirect($this->generateUrl('fos_user_registration_register', array('offer' => $pCode[0]->getOffer()->getId())));
               }
           }
           
           return $this->redirect($this->generateUrl('wrong_pcode'));
        }
        
        return array('form' => $form->createView());
    }
    
    /**
     * @Route("/erreurCode", name="wrong_pcode")     
     * @Template("EltonPaymentBundle:PCode:error.html.twig")
     */
    public function wrongPCodeAction(){
        
        return array();
    }

}
