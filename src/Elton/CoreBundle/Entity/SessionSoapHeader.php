<?php
namespace Elton\CoreBundle\Entity;
	class SessionSoapHeader
	{
		public $SID;	// Identifiant de session.

	  function __construct($sessionID)
	  {
	     $this->SID  = $sessionID;
	  }
	}