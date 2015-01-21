<?php

namespace Elton\CoreBundle\Entity;

class AuthentificationSoapHeader
{
        public $UID;	// Identifiant utilisateur.
        public $PWD;	// Mot de passe utilisateur.

  function __construct($login, $password)
  {
     $this->UID  = $login;
     $this->PWD = $password;
  }
}