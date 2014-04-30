<?php

namespace Elton\LessonBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * LessonRepository
 *
 */
class LessonRepository extends EntityRepository
{
    /**
     * Function used to count the number of Lessons
     * @return array with one int
     */
    public function count()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT count(l)
             FROM EltonLessonBundle:Lesson l');

        $result = $query->getSingleResult();
        
        return $result;
    }
    
    /**
     * Function used to find lessons by the their level
     * @param int $level id of the level
     * @return array of Lesson
     */
    public function getLessonByLevel($level)
    {
        $level = (int)$level;
        $em = $this->getEntityManager();
        $query = $em->createQuery(
                'Select l
                From EltonLessonBundle:Lesson l
                Join l.level le
                Where le.id = ?1');
        $query->setParameter(1, $level);
        $result = $query->getResult();
        
        return $result;
    }
    
    /**
     * Function used to find lessons by the their category
     * @param string $category libelle of the category
     * @return array of Lesson
     */
    public function getLessonByCategory($category)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
                'Select l
                From EltonLessonBundle:Lesson l
                Join l.category c
                Where c.libelle = ?1');
        $query->setParameter(1, $category);
        $result = $query->getResult();
        
        return $result;
    }
}
