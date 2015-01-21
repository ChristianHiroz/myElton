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
     * @Route("/payment/form/{id}", name="teacher_payment_form")
     * @Template("EltonPaymentBundle:Payment:form.html.twig")
     */
    public function paymentFormAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $jumbotron = $em->getRepository('EltonCoreBundle:Jumbotron');
        $user = $this->container->get('elton.teacher.manager')->getRepository()->find($id);
        $numCommande = "ELTON" . date("Y") . date("n") . date("d") . $jumbotron->find(1)->getNmcmd();
        $em->persist($jumbotron->find(1));
        $subscription = $user->getSubscriptions()->last();
        $subscription->setOrderId($numCommande);
        $em->persist($user);
        $em->flush();
	$shastring = $subscription->getOrderID() . ($subscription->getOffer()->getPrice()*100) . "EUR".$this->get('elton.payment')->getPspId().$this->get('elton.payment')->getShaSign();
        return array(
            'user' => $user,
            'offer' => $subscription->getOffer(),
            'ogoneAddress' => $this->get('elton.payment')->getOgoneAddress(),
            'pspid' => $this->get('elton.payment')->getPspId(),
            'shastring' => strtoupper(sha1($shastring)), 
            'numCommande' => $subscription->getOrderID(),
            'montant' => $subscription->getOffer()->getPrice()*100,
            'accepturl' => $this->get('router')->generate('accepturl'),
            'cancelurl' => $this->get('router')->generate('cancelurl'),
            'declineurl' => $this->get('router')->generate('declineurl'),
            'exceptionurl' => $this->get('router')->generate('exceptionurl'),
            );
    }
    
    /**
     * @Route("/renvoiePaiement", name="send_payment_request")
     * @Template("EltonPaymentBundle:Payment:sendPaymentRequest.html.twig")
     */
    public function sendPaymentRequestAction()
    {
        $returnArray = $this->container->get('elton.teacher.manager')->check();
        
        //envoie la template request payment
        $this->container->get('elton.mailer')->sendPaymentRequest($returnArray['user'], false);
        
        return $returnArray;
    }
    
    /**
     * @Route("/relancePaiement/{offer}", name="send_payment_relance")
     * @Template("EltonPaymentBundle:Payment:sendPaymentRequest.html.twig")
     */
    public function sendPaymentRelanceAction($offer)
    {
        $returnArray = $this->container->get('elton.teacher.manager')->check();
        $subscription = new \Elton\PaymentBundle\Entity\Subscription();
        $offerO = $this->container->get('elton.offer.manager')->getRepository()->find($offer);
        $subscription->setOffer($offerO);
        $returnArray['user']->setSubscription($subscription);
        
        $this->container->get('elton.teacher.manager')->persist($returnArray['user']);
        
        //envoie la template request payment
        $this->container->get('elton.mailer')->sendPaymentRequest($returnArray['user'], true);
        
        return $returnArray;
    }
    
    /**
     * @Route("/payment/transaction", name="accepturl")
     * @Template("EltonPaymentBundle:Payment:accept.html.twig")
     */
    public function getOgoneReturn()
    {
        $srzed = serialize($this->get('request')->request->all());
        $fh = fopen('test.txt','a+'); // Ouverture d'un fichier en lecture/écriture, en le créant s'il n'existe pas.
        fwrite($fh,$srzed); // On écrit.
        fclose($fh); // On ferme.
//        var_dump($_POST['STATUS']);die();
//        $arrayOgone = array();
//        $arrayOgone['ACCEPTANCE'] = $_POST['ACCEPTANCE'];
//        $arrayOgone['AMOUNT'] = $_POST['AMOUNT'];
//        $arrayOgone['BRAND'] = $_POST['BRAND'];
//        $arrayOgone['CARDNO'] = $_POST['CARDNO'];
//        $arrayOgone['CURRENCY'] = $_POST['CURRENCY'];
//        $arrayOgone['NCERROR'] = $_POST['NCERROR'];
//        $arrayOgone['orderID'] = $_POST['orderID'];
//        $arrayOgone['PAYID'] = $_POST['PAYID'];
//        $arrayOgone['STATUS'] = $_POST['STATUS'];
//        $order = $_POST['orderID'];
//        $returnArray = $this->container->get('elton.teacher.manager')->check();
//        $this->container->get('elton.subscription.manager')->updateSubscription($returnArray['user']->getSubscriptions()->get($returnArray['user']->getSubscriptions()->count() - 1), 1);
//       
//        //ajout du role premium
//        $returnArray['user']->addRole("ROLE_TEACHER_PREMIUM");
//        $this->container->get('elton.teacher.manager')->persist($returnArray['user']);
//        
//        //envoie du mail de confirmation
//
//        $this->container->get('elton.mailer')->sendPaymentConfirmation($returnArray['user']);
//        
//        $subscriptionManager = $this->container->get('elton.subscription.manager');
//        $subscription = $subscriptionManager->getRepository()->getSubscriptionByCode($order);
//        $subscriptionManager->updateSubscriptionOgone($subscription[0], $arrayOgone);
        
        return $returnArray;
    }
    /**
     * @Route("/paiement/1", name="accepturl")
     * @Template("EltonPaymentBundle:Payment:accept.html.twig")
    */
    public function acceptAction()
    {
        $returnArray = $this->container->get('elton.teacher.manager')->check();
        $this->container->get('elton.subscription.manager')->updateSubscription($returnArray['user']->getSubscriptions()->get($returnArray['user']->getSubscriptions()->count() - 1), 1);
       
        //ajout du role premium
        $returnArray['user']->addRole("R0LE_TEACHER_PREMIUM");
        $this->container->get('elton.teacher.manager')->persist($returnArray['user']);
        
        //envoie du mail de confirmation
        $this->container->get('elton.mailer')->sendPaymentConfirmation($returnArray['user']);
        
        return $returnArray;
    }
    
    /**
     * @Route("/paiement/2", name="declineurl")     
     * @Template("EltonPaymentBundle:Payment:decline.html.twig")
    */
    public function declineAction()
    {
        $returnArray = $this->container->get('elton.teacher.manager')->check();
        $this->container->get('elton.subscription.manager')->updateSubscription($returnArray['user']->getSubscriptions()->get($returnArray['user']->getSubscriptions()->count() - 1), 1);

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
        $this->container->get('elton.subscription.manager')->updateSubscription($returnArray['user']->getSubscriptions()->get($returnArray['user']->getSubscriptions()->count() - 1), 1);

        
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
        $this->container->get('elton.subscription.manager')->updateSubscription($returnArray['user']->getSubscriptions()->get($returnArray['user']->getSubscriptions()->count() - 1), 1);
        
        $this->container->get('elton.subscription.manager')->updateSubscription($returnArray['user']->getSubscriptions()->last(), 4);
            
        return $returnArray;
    }

}
