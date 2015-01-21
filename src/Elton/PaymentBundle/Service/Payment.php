<?php
/**
 * Service that perform payment link creation, and response handling.
 *
 * @author Christian Hiroz
 */


namespace Elton\PaymentBundle\Service;

class Payment
{
    protected $pspid;
    protected $ogoneAddress;
    protected $shasign;
    protected $request;
    
    public function __construct()
    {
        $this->pspid = "PBPPLAYBAC";
        $this->ogoneAddress = "https://secure.ogone.com/ncol/prod/orderstandard.asp";
        $this->shasign = "wegener";
    }
    
    public function testAccept(){
        var_dump($this->request->get('ACCEPTANCE'));exit;
    }
    
    public function getPspId()
    {
        return $this->pspid;
    }
    
    public function getOgoneAddress()
    {
        return $this->ogoneAddress;
    }
    
    public function getShaSign()
    {
        return $this->shasign;
    }
}
