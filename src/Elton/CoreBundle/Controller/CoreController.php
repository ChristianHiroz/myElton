<?php

namespace Elton\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Elton\CoreBundle\Entity\AuthentificationSoapHeader;
use Elton\CoreBundle\Entity\SessionSoapHeader;


/**
 * Core controller
 * 
 */
class CoreController extends Controller
{
    /**
     * @Route("/stats", name="stats")
     * @Method({"POST"})
     * @Template("EltonCoreBundle:Core:stats.html.twig")
     */
    public function statistiqueAction()
    {
        $nbTeachers = $this->get('elton.teacher.manager')->getRepository()->count();
        $nbDivisions = $this->get('elton.division.manager')->getRepository()->count();
        $nbLessons = $this->get('elton.lesson.manager')->getRepository()->count();
        $nbFiles = $this->get('elton.file.manager')->getRepository()->count();
        
        return array('nbT' => $nbTeachers[1], 'nbD' => $nbDivisions[1], 'nbL' => $nbLessons[1], 'nbF' => $nbFiles[1]);
    }
    
    /**
     * @Route("/", name="index")
     * @Method({"POST"})
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
     * @Route("/try/{cp}", name="tryAjax", options={"expose"=true})
     * @Method("GET")
     */
    public function tryAction($cp)
    {
        $session = new Session();
        $render = array ("NOM" => array(), "VOIE" => array(), "VILLE" => array(),);
        $wsdlName = "https://simple.bisnode.fr/WebServices/GeoLocalisation.asmx?wsdl";
        $wsNamespace = "http://services.bisnode.fr";
        $soapClient = new \SoapClient($wsdlName, array("trace" => true));
        $soapClientHeader = new \SoapHeader($wsNamespace, "AuthentificationSoapHeader", new AuthentificationSoapHeader("PBPWS001", "d4f5b48e-b20d"), true);
        $soapClient->__setSoapHeaders($soapClientHeader);
        $IDSession = $soapClient->WSAuthentification()->WSAuthentificationResult;
        
        $session->set('idWS', $IDSession);
	$soapClientHeaderSecond = new \SoapHeader($wsNamespace, "SessionHeader", new SessionSoapHeader($IDSession), true);
        
        $soapClient->__setSoapHeaders($soapClientHeaderSecond);
        
        $result = $soapClient->GetLocalSchools(array("codePostal" => $cp))->GetLocalSchoolsResult;
        $xmlDoc = new \DomDocument("1.0", "utf-8");
        $xmlDoc->preserveWhiteSpace = false;
        $xmlDoc->formatOutput = true;
        $xmlDoc->loadXML($result);

        $noms = $xmlDoc->getElementsByTagName("NOM");
        $adresses = $xmlDoc->getElementsByTagName("VOIE");
        $villes = $xmlDoc->getElementsByTagName("COMMUNE");
        $i = 1;
        foreach ($noms as $nom)
        {
            $render['NOM'][$i] = $nom->nodeValue;
            if(isset($adresses->item($i)->nodeValue))
            {
                $render['VOIE'][$i] = $adresses->item($i)->nodeValue;
            }
            else 
            {
                $render['VOIE'][$i] = "";
            }
            if(isset($villes->item($i)->nodeValue))
            {
                $render['VILLE'][$i] = $villes->item($i)->nodeValue;
            }
            else
            {
                $render['VILLE'][$i] = "";
            }
            $i = $i + 1;
        }
        
        echo (\json_encode($render));
        
        return new Response();
    }
}
