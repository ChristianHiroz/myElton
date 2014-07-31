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
    
    /**
     * @Route("/", name="index")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction()
    {                
        $returnArray = $this->get('elton.teacher.manager')->check();
        $em = $this->getDoctrine()->getEntityManager();
        $em->getConnection()->getConfiguration()->setSQLLogger(null);
        if(is_array($returnArray) && array_key_exists('user', $returnArray))
        {
            if(is_object($returnArray['selectedDivision']))
            {
                return $this->redirect($this->generateUrl('practice'));
            }
            else
            {
                return $this->redirect($this->generateUrl('teacher_create_division'));
            }
        }
        return $returnArray;
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
