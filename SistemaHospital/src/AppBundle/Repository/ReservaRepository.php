<?php

namespace AppBundle\Repository;

use AppBundle\AppBundle;
use AppBundle\Entity\Reserva;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToTimestampTransformer;
use Symfony\Component\Validator\Constraints\DateTime;

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


    public function filtrarReservas($datos){

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb ->select('r')
            ->from('AppBundle:Reserva', 'r');
        if(isset($datos["fechaIni"] ) && isset($datos["fechaFin"])){

            $qb
            ->where('r.fecha_inicio BETWEEN :firstDate AND :lastDate')
            ->setParameter('firstDate', new \DateTime($datos["fechaIni"]))
            ->setParameter('lastDate', new \DateTime($datos["fechaFin"]));
        }

        if(isset($datos["numeroReserva"] )){
            $qb ->andWhere('r.numeroReserva = :numeroReserva')
                ->setParameter('numeroReserva', $datos["numeroReserva"] );
        }
        if(isset($datos["servicios"])){
            /*$qb->andWhere('r.servicio.getId() = :servicio')
            ->setParameter('servicio', $datos["servicios"]);
            echo ("entreeee");*/
            //->innerJoin('u', 'phonenumbers', 'p', 'u.id = p.user_id')
           //$servicio= $this->getEntityManager()->getRepository("AppBundle:Servicio")->find(4);
            $qb ->andWhere("r.servicio = :servicio")
                ->setParameter("servicio", $datos["servicios"]);
        }

        if(isset($datos["paciente"])){
            $qb ->andWhere("r.paciente = :paciente")
                ->setParameter("paciente", $datos["paciente"]);
        }

        return $qb->getQuery();

    }

    /**
     * @param int $page
     * @return Pagerfanta
     */
    public function findLatest($page = 1, $datos)
    {
        if($datos !== null)
        {

            //$paginator = new Pagerfanta(new DoctrineORMAdapter($this->reservasEntre($datos["fechaIni"], $datos["fechaFin"]), false));
            $paginator = new Pagerfanta(new DoctrineORMAdapter($this->filtrarReservas($datos), false));
        }else{
            $paginator = new Pagerfanta(new DoctrineORMAdapter($this->queryLatest(), false));
        }
        $paginator->setMaxPerPage(self::NUMPAG);// llama a global en personal para cantidad de paginas Personal::NUM_ITEMS
        $paginator->setCurrentPage($page);

//        echo("llegue");
//        echo(count($paginator));

        return $paginator;
    }

    public function findPendientes($fecha,$fecha2)
    {
        $lista = $this->reservasEntre($fecha, $fecha2)->execute();
        return $lista;

    }
}

