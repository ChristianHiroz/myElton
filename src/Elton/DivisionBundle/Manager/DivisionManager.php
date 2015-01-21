<?php
/**
 * Description of DivisionManager
 *
 * @author Christian Hiroz
 */

namespace Elton\DivisionBundle\Manager;

use Doctrine\ORM\EntityManager;
use Elton\CoreBundle\Manager\CoreManager as CoreManager;

class DivisionManager extends CoreManager
{
    protected $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getRepository()
    {
        return $this->em->getRepository('EltonDivisionBundle:Division');
    }
}
