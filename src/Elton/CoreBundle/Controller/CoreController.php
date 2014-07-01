<?php

namespace Elton\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;


/**
 * Core controller
 * 
 */
class CoreController extends Controller
{
    private function check()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        if(is_object($user) && $user->hasRole('ROLE_USER'))
        {
            $selectedDivision = $this->get('elton.division.manager')->getRepository()->getSelectedDivisionByTeacherId($user->getId());
            $othersDivisions = $this->get('elton.division.manager')->getRepository()->getNotSelectedDivisionByTeacherId($user->getId());
            $categorys = $this->get('elton.category.manager')->getRepository()->getCategoryByLevelId($selectedDivision[0]->getLevel()->getId());
            
            $returnArray =  array('user' => $user, 
                         'selectedDivision' => $selectedDivision[0], 
                         'othersDivisions' => $othersDivisions,
                         'categorys' => $categorys);          
        }
        
        return $returnArray;
    }
    
    /**
     * @Route("/", name="index")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction()
    {                
        $user = $this->get('security.context')->getToken()->getUser();
        if(is_object($user) && $user->hasRole('ROLE_USER'))
        {
            $selectedDivision = $this->get('elton.division.manager')->getRepository()->getSelectedDivisionByTeacherId($user->getId());
            if($selectedDivision == null)
            {
                return $this->redirect($this->generateUrl("teacher_create_division")); 
            }
            $othersDivisions = $this->get('elton.division.manager')->getRepository()->getNotSelectedDivisionByTeacherId($user->getId());
            $categorys = $this->get('elton.category.manager')->getRepository()->getCategoryByLevelId($selectedDivision[0]->getLevel()->getId());
            
            return array('user' => $user, 
                         'selectedDivision' => $selectedDivision[0], 
                         'othersDivisions' => $othersDivisions,
                         'categorys' => $categorys);          
        }
        else
        {
            return array('user' => $user,);
        }
    }
    
    /**
     * @Route("/en-savoir-plus", name="savoir_plus")
     * @Method({"GET"})
     * @Template("EltonCoreBundle:Core:en-savoir-plus.html.twig")
     */
    public function enSavoirPlusAction()
    {
        return array();
    }
    
    /**
     * @Route("/a-propos", name="a_propos")
     * @Method({"GET"})
     * @Template("EltonCoreBundle:Core:a-propos.html.twig")
     */
    public function aProposAction()
    {
        return array();
    }
    
    /**
     * @Route("/cgu", name="cgu")
     * @Method({"GET"})
     * @Template("EltonCoreBundle:Core:cgu.html.twig")
     */
    public function cguAction()
    {
        return array();
    }
    
    /**
     * @Route("/sitemap", name="sitemap")
     * @Method({"GET"})
     * @Template("EltonCoreBundle:Core:sitemap.html.twig")
     */
    public function siteMapAction()
    {
        return array();
    }
    
    /**
     * @Route("/foire-aux-questions", name="faq")
     * @Method({"GET"})
     * @Template("EltonCoreBundle:Core:faq.html.twig")
     */
    public function faqAction()
    {
        return array();
    }
    
    /**
     * @Route("/try/{cp}", name="tryAjax", options={"expose"=true})
     * @Method("GET")
     */
    public function tryAction($cp)
    {
        $xmlDoc = $this->get('elton.core.manager')->schoolWS($cp);
        $render = $this->get('elton.core.manager')->fillSchoolArray($xmlDoc);
        
        echo (\json_encode($render));
        return new Response();
    }
}
