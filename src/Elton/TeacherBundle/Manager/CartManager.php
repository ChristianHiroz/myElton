<?php
/**
 * Description of CartManager
 *
 * @author Christian Hiroz
 */

namespace Elton\TeacherBundle\Manager;

use Doctrine\ORM\EntityManager;
use Elton\CoreBundle\Manager\CoreManager as CoreManager;
use Elton\TeacherBundle\Entity\CartActivity;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class CartManager extends CoreManager
{
    protected $em;
    protected $container;


    public function __construct(EntityManager $em, Container $container)
    {
        $this->em = $em;
        $this->container = $container;
    }
    
    public function getRepository()
    {
        return $this->em->getRepository('EltonTeacherBundle:Cart');
    }
    
    public function addActivity(\Elton\LessonBundle\Entity\Activity $activity)
    {
        $teacher = $this->container->get('security.context')->getToken()->getUser();
        $selectedDivision = $this->container->get('elton.division.manager')->getRepository()->getSelectedDivisionByTeacherId($teacher->getId());
        
        $cartActivity = new CartActivity();
        $this->fillCartActivity($selectedDivision[0]->getCart(), $activity, $cartActivity);
        
        $this->em->persist($cartActivity);
        $this->em->flush();
    }
    
    public function fillCartActivity(\Elton\TeacherBundle\Entity\Cart $cart, \Elton\LessonBundle\Entity\Activity $activity, CartActivity $cartActivity)
    {
        $cartActivity->setCart($cart);
        $cartActivity->setActivity($activity);
    }
    
    /**
     * 
     * @param cart $cart cart entity
     * @param bool $setted if the activity is the setted to the division = true, def false
     * @return arrayCollection collection of cartActivity setted to $setted
     */
    public function getCartActivity($cart, $setted = false)
    {
        $activitys = new \Doctrine\Common\Collections\ArrayCollection();
        foreach ($cart->getActivitys() as $activity)
        {
            if($activity->isSetted() == $setted)
            {
                $activitys->add($activity);
            }
        }
        return $activitys;
    }
}
