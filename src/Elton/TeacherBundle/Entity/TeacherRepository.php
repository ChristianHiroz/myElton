<?php

namespace Elton\TeacherBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TeacherRepository
 *
 */
class TeacherRepository extends EntityRepository
{
    /**
     * Function used to count the number of Teacher
     * @return array with one int
     */
    public function count()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT count(t)
             FROM EltonTeacherBundle:Teacher t');

        $result = $query->getSingleResult();
        
        return $result;
    }
    
    /**
     * Function used to find teachers by the level of their division
     * @param int $level id of the level
     * @return array of Teacher
     */
    public function getTeacherByLevel($level)
    {
        $level = (int)$level;
        $em = $this->getEntityManager();
        $query = $em->createQuery(
                'Select t
                From EltonTeacherBundle:Teacher t
                Join t.divisions d
                Join d.level l
                Where l.id = ?1');
        $query->setParameter(1, $level);
        $result = $query->getResult();
        
        return $result;
    }
    
    /**
     * Function used to find a teacher by his name
     * @param string $name name of the teacher you are looking for
     * @return array of Teacher
     */
    public function getTeacherByName($name)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
                'Select t
                 From EltonTeacherBundle:Teacher t
                 Where t.name = ?1');
        $query->setParameter(1, $name);
        $result = $query->getResult();
        
        return $result;
    }
    
    /**
     * Function used to find a teacher by his username
     * @param string $username username of the teacher you are looking for
     * @return array with one teacher
     */
    public function getTeacherByUserName($username)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
                'Select t
                 From EltonTeacherBundle:Teacher t
                 Where t.username = ?1');
        $query->setParameter(1, $username);
        $result = $query->getSingleResult();
        
        return $result;
    }
    
    /**
     * Function used to find teachers of a department
     * @param string $pc postal code of the department
     * @return array of Teachers
     */
    public function getTeacherByPostalCode($pc)
    {
        $pc = substr($pc, 0, 2);
        $em = $this->getEntityManager();
        $query = $em->createQuery(
                'Select t
                 From EltonTeacherBundle:Teacher t
                 Where t.postalCode LIKE :key');
        $query->setParameter('key', $pc.'%');      
        $result = $query->getResult();
        
        return $result;
    }
    
}
