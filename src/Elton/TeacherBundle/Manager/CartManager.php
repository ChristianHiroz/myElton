<?php
/**
 * Description of CartManager
 *
 * @author Christian Hiroz
 */

namespace Elton\TeacherBundle\Manager;

use Doctrine\ORM\EntityManager;
use Elton\CoreBundle\Manager\CoreManager as CoreManager;

class CartManager extends CoreManager
{
    protected $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getRepository()
    {
        return $this->em->getRepository('EltonTeacherBundle:Cart');
    }
}
