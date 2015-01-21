<?php
/**
 * Description of TeacherManager
 *
 * @author Christian Hiroz
 */

namespace Elton\TeacherBundle\Manager;

use Doctrine\ORM\EntityManager;
use Elton\TeacherBundle\Entity\Teacher;
use Elton\CoreBundle\Manager\CoreManager as CoreManager;

class TicketManager extends CoreManager
{
    protected $em;
    protected $container;


    public function __construct(EntityManager $em, \Symfony\Component\DependencyInjection\Container $container)
    {
        $this->em = $em;
        $this->container = $container;
    }
    
    public function getRepository()
    {
        return $this->em->getRepository('EltonTeacherBundle:Ticket');
    }
    
    public function isOpenTicket()
    {
        $openTicket = $this->getRepository()->getOpenTicket();
        if(!empty($openTicket)){
            return true;
        }
        else {
            return false;
        }
    }

}
