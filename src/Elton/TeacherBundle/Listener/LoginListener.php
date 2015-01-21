<?php

namespace Elton\TeacherBundle\Listener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Elton\TeacherBundle\Entity\Teacher;

/**
 * Description of LoginListener
 *
 * @author rarity
 */
class LoginListener {
    
        /** @var \Symfony\Component\Security\Core\SecurityContext */
	private $securityContext;
	
	/** @var \Doctrine\ORM\EntityManager */
	private $em;
        
        // Elton mailer
        private $mailer;
	
	/**
	 * Constructor
	 * 
	 * @param SecurityContext $securityContext
	 * @param Doctrine        $doctrine
	 */
	public function __construct(SecurityContext $securityContext, Doctrine $doctrine, $mailer)
	{
            $this->securityContext = $securityContext;
            $this->em              = $doctrine->getEntityManager();
            $this->mailer = $mailer;
	}
	
	/**
	 * Do the magic.
	 * 
	 * @param InteractiveLoginEvent $event
	 */
	public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
	{
            if ($this->securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
		// user has just logged in		
            }
            if ($this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
		// user has logged in using remember_me cookie
            }
            $user = $event->getAuthenticationToken()->getUser();
            if($user instanceof Teacher) {
                $subscriptionEnd = $user->getSubscriptions()->last()->getOffer()->getEndAt();
                $subscriptionStart = $user->getSubscriptions()->last()->getSubscriptionDate();
                if($subscriptionEnd < new \DateTime() OR $subscriptionEnd == NULL){
                    if($user->getSubscriptions()->last()->getIsPaymentValid()) {
                        //plus PREMIUM
                        $user->removeRole("ROLE_TEACHER_PREMIUM");
                    }
                }
                if(!$user->hasRole("ROLE_TEACHER_INACTIF") OR !$user->hasRole("ROLE_TEACHER_INACTIF") OR !$user->hasRole("ROLE_TEACHER_PAYING")){
                    $user->addRole("ROLE_TEACHER_PAYING");
                }

                $this->em->persist($user);
                $this->em->flush();
            }
	}
}
