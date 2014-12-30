<?php
/**
 * Description of FileManager
 *
 * @author Christian Hiroz
 */

namespace Elton\CoreBundle\Manager;

use Doctrine\ORM\EntityManager;

class JumbotronManager extends CoreManager{
    protected $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getRepository()
    {
        return $this->em->getRepository('EltonCoreBundle:Jumbotron');
    }
}
