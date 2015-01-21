<?php
/**
 * Description of LevelManager
 *
 * @author Christian Hiroz
 */

namespace Elton\CoreBundle\Manager;

use Doctrine\ORM\EntityManager;

class LevelManager extends CoreManager
{
    protected $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getRepository()
    {
        return $this->em->getRepository('EltonCoreBundle:Level');
    }
}
