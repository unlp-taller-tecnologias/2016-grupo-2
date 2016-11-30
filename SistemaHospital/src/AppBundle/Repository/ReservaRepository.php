<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
/**
 * ReservaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReservaRepository extends \Doctrine\ORM\EntityRepository
{
    const NUMPAG=20;
    /**
     * @return Query
     */
    public function queryLatest()
    {
        return $this->getEntityManager()
            ->createQuery('
                SELECT p
                FROM AppBundle:Reserva p
                WHERE p.fecha_inicio <= :now
                ORDER BY p.fecha_inicio DESC
            ')
            ->setParameter('now', new \DateTime());
    }

    public function reservasEntre($fechadesde, $fechahasta)
    {
        return $this->getEntityManager()
            ->createQuery( "
          SELECT r
          FROM AppBundle:Reserva r
          where r.fecha_inicio BETWEEN :fechaDesde and :fechaHasta
          ORDER BY r.fecha_inicio DESC
          ")
            ->setParameter('fechaDesde', new \DateTime($fechadesde))
            ->setParameter('fechaHasta', new \DateTime($fechahasta))
            ;
    }

    /**
     * @param int $page
     * @return Pagerfanta
     */
    public function findLatest($page = 1, $datos)
    {
        if($datos !== null)
        {
            $paginator = new Pagerfanta(new DoctrineORMAdapter($this->reservasEntre($datos["fechaIni"], $datos["fechaFin"]), false));
        }else{
            $paginator = new Pagerfanta(new DoctrineORMAdapter($this->queryLatest(), false));
        }
        $paginator->setMaxPerPage(self::NUMPAG);// llama a global en personal para cantidad de paginas Personal::NUM_ITEMS
        $paginator->setCurrentPage($page);

        return $paginator;
    }
}


