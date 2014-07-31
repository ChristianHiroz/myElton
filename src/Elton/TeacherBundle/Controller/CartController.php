<?php

namespace Elton\TeacherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Cart controller.
 *
 * @Route("/cart")
 */
class CartController extends Controller
{   
    
    /**
     * @Route("/show", name="show_cart")
     * @Method({"GET"})
     * @Template()
     */
    public function showAction()
    {
        $returnArray = $this->get('elton.teacher.manager')->check();
        $cart = $returnArray['selectedDivision']->getCart();
        $settedCart = $this->getDoctrine()->getEntityManager()->getRepository('EltonTeacherBundle:CartActivity')->getCartActivityBySetted($cart->getId(), true);
        $unsettedCart = $this->getDoctrine()->getEntityManager()->getRepository('EltonTeacherBundle:CartActivity')->getCartActivityBySetted($cart->getId());
        
        $returnArray['cart'] = $unsettedCart;
        $returnArray['settedCart'] = $settedCart;
        return $returnArray;
    }
    
    /**
     * @Route("/add/{id}", name="add_cart", options={"expose"=true})
     * @Method("GET")
     */
    public function addCartAction($id)
    {
        $activity = $this->get('elton.activity.manager')->getRepository()->findById($id);
        
        $this->get('elton.cart.manager')->addActivity($activity[0]);
        
        return new \Symfony\Component\HttpFoundation\Response;
    }
    
    /**
     * @Route("/set/{activityId}/{cartId}", name="set_to_division", options={"expose"=true})
     * @Method("GET")
     */
    public function setToDivisionAction($activityId, $cartId)
    {
        $cart = $this->getDoctrine()->getEntityManager()->getRepository("EltonTeacherBundle:Cart")->find($cartId);
        $activity = $this->getDoctrine()->getEntityManager()->getRepository("EltonLessonBundle:Activity")->find($activityId);
        $activityCart = $this->getDoctrine()->getEntityManager()->getRepository('EltonTeacherBundle:CartActivity')->getCartActivity($cart, $activity);
        $activityCart->setSetted();
        $this->getDoctrine()->getEntityManager()->persist($activityCart);
        $this->getDoctrine()->getEntityManager()->flush();
        
        return new \Symfony\Component\HttpFoundation\Response;
    }
    
    /**
     * @Route("/empty", name="empty_cart")
     */
    public function viderPanierAction()
    {
        $returnArray = $this->get('elton.teacher.manager')->check();
        
        $cart = $returnArray['selectedDivision']->getCart();
        $cartActivitys = $cart->getActivitys();
        foreach($cartActivitys as $cartActivity)
        {
            $this->getDoctrine()->getEntityManager()->remove($cartActivity);
        }
        $this->getDoctrine()->getEntityManager()->flush();
        
        return $this->redirect($this->generateUrl('show_cart'));
    }
    
    /**
     * @Route("/supprimer/{id}", name="delete_cart", options={"expose"=true})
     * @Method({"GET"})
     */
    public function deletePanierAction($id)
    {
        $returnArray = $this->get('elton.teacher.manager')->check();
        
        $cart = $returnArray['selectedDivision']->getCart();
        $activity = $this->getDoctrine()->getEntityManager()->getRepository("EltonLessonBundle:Activity")->find($id);
        $cartActivity = $this->getDoctrine()->getEntityManager()->getRepository("EltonTeacherBundle:CartActivity")->getCartActivity($cart, $activity);
        $this->getDoctrine()->getEntityManager()->remove($cartActivity);
        $this->getDoctrine()->getEntityManager()->flush();
        
        return new \Symfony\Component\HttpFoundation\Response;
    }
}