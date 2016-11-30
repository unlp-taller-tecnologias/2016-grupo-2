<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Controller\ReservaController;
use AppBundle\Entity\Reserva;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * This custom Doctrine repository contains some methods which are useful when
 * querying for blog post information.
 * See http://symfony.com/doc/current/book/doctrine.html#custom-repository-classes
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class ReservaRepository extends EntityRepository
{

    const NUM_ITEMS = 100;
    /**
     * @return Query
     */
    public function queryLatest()
    {

        //esto es en realidad mayor
        return $this->getEntityManager()
            ->createQuery('
                SELECT r
                FROM AppBundle:Reserva r
                WHERE r.fecha_inicio <= :now
                ORDER BY r.fecha_inicio ASC
            ')
            ->setParameter('now', new \DateTime())
        ;
    }


   /* public function queryHistorical()
    {
        return $this->getEntityManager()
            ->createQuery('
                SELECT p
                FROM AppBundle:Reserva r
                WHERE r.fecha_inicio <= :now
                ORDER BY r.fecha_inicio DESC
            ')
            ->setParameter('now', new \DateTime())
            ;
    }*/

    /**
     * @param int $page
     *
     * @return Pagerfanta
     */
    public function findLatest($page = 1)
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($this->queryLatest(), false));
        $paginator->setMaxPerPage(40);
        $paginator->setCurrentPage($page);

        return $paginator;
    }

    /*public function findHistorical($page = 1)
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($this->queryHistorical(), false));
        $paginator->setMaxPerPage(self::numPaginas);
        $paginator->setCurrentPage($page);

        return $paginator;
    }*/
}
