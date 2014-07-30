<?php
/**
 * Description of CoreManager
 *
 * @author Christian Hiroz
 */
namespace Elton\CoreBundle\Manager;

use Elton\CoreBundle\Entity\AuthentificationSoapHeader;
use Elton\CoreBundle\Entity\SessionSoapHeader;

 class CoreManager
{
    public function persist($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }
    
    /*
     * Call a web service that provides informations about every school from a department
     * @param int $cp postal code
     * @return xml doc that contain information about school from the department (cp)
     */
    public function schoolWS($cp)
    {
        $wsdlName = "https://simple.bisnode.fr/WebServices/GeoLocalisation.asmx?wsdl";
        $wsNamespace = "http://services.bisnode.fr";
        $soapClient = new \SoapClient($wsdlName, array("trace" => true));
        $soapClientHeader = new \SoapHeader($wsNamespace, "AuthentificationSoapHeader", new AuthentificationSoapHeader("PBPWS001", "d4f5b48e-b20d"), true);
        $soapClient->__setSoapHeaders($soapClientHeader);
        $IDSession = $soapClient->WSAuthentification()->WSAuthentificationResult;
	$soapClientHeaderSecond = new \SoapHeader($wsNamespace, "SessionHeader", new SessionSoapHeader($IDSession), true);
        
        $soapClient->__setSoapHeaders($soapClientHeaderSecond);
        
        $result = $soapClient->GetLocalSchools(array("codePostal" => $cp))->GetLocalSchoolsResult;
        $xmlDoc = new \DomDocument("1.0", "utf-8");
        $xmlDoc->preserveWhiteSpace = false;
        $xmlDoc->formatOutput = true;
        $xmlDoc->loadXML($result);
        
        return $xmlDoc;
    }
    
    /**
     * Function that fill up an array with schools informations from a xmlDocument
     * @param xml document $xmlDoc
     * @return array that contain xmldoc information
     */
    public function fillSchoolArray($xmlDoc)
    {
        $render = array ("NOM" => array(), "VOIE" => array(), "VILLE" => array(),);
        $noms = $xmlDoc->getElementsByTagName("NOM");
        $adresses = $xmlDoc->getElementsByTagName("VOIE");
        $villes = $xmlDoc->getElementsByTagName("COMMUNE");
        $i = 1;
        foreach ($noms as $nom)
        {
            $render['NOM'][$i] = $nom->nodeValue;
            if(isset($adresses->item($i)->nodeValue)) {$render['VOIE'][$i] = $adresses->item($i)->nodeValue;}
            else { $render['VOIE'][$i] = "";}
            if(isset($villes->item($i)->nodeValue)) {$render['VILLE'][$i] = $villes->item($i)->nodeValue;}
            else {$render['VILLE'][$i] = "";}
            $i = $i + 1;
        }
        
        return $render;
    }
}
