<?php

namespace AppBundle\Repository;

/**
 * OperacionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
use AppBundle\Entity\Operacion;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class OperacionRepository extends \Doctrine\ORM\EntityRepository
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
                FROM AppBundle:Operacion p
                JOIN p.reserva r
                WHERE r.fecha_inicio <= :now
                ORDER BY r.fecha_inicio DESC
            ')
            ->setParameter('now', new \DateTime());
    }

    public function operacionEntre($fechadesde, $fechahasta)
    {

        return $this->getEntityManager()
            ->createQuery( "
          SELECT o
          FROM AppBundle:Operacion o
          JOIN o.reserva r 
          where r.fecha_inicio BETWEEN :fechaDesde and :fechaHasta
          ORDER BY r.fecha_inicio DESC
          ")
            ->setParameter('fechaDesde', new \DateTime($fechadesde))
            ->setParameter('fechaHasta', new \DateTime($fechahasta))
            ;
    }


    public function filtrarReservas($datos){


        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb ->select('o')
            ->from('AppBundle:Operacion', 'o')
            ->join('o.reserva', 'r');
        if(isset($datos["fechaIni"] ) && isset($datos["fechaFin"])){

            $qb
                ->where('r.fecha_inicio BETWEEN :firstDate AND :lastDate')
                ->setParameter('firstDate', new \DateTime($datos["fechaIni"]))
                ->setParameter('lastDate', new \DateTime($datos["fechaFin"]));
            echo("entre en fecha \n");
        }

        if(isset($datos["numeroReserva"] )){
            $qb ->andWhere('r.numeroReserva = :numeroReserva')
                ->setParameter('numeroReserva', $datos["numeroReserva"] );
            echo("entre en numero de reserva \n");
        }
        if(isset($datos["servicios"])){

            $qb ->andWhere("r.servicio = :servicio")
                ->setParameter("servicio", $datos["servicios"]);
            echo("entre en servicios \n");
        }

        if(isset($datos["paciente"])){
            $qb ->andWhere("r.paciente = :paciente")
                ->setParameter("paciente", $datos["paciente"]);
            echo("entre en paciente \n");
        }

        if(isset($datos["esInternado"])){
            $qb ->andWhere("o.internado = :internado")
                ->setParameter("internado", ($datos["esInternado"] == "si")? true : false);
            echo("entre en esInternado \n");
        }

        if(isset($datos["tq"])){
            $qb ->andWhere("o.tq = :tq")
                ->setParameter("tq", $datos["tq"]);
            echo("entre en tq \n");

        }

        if(isset($datos["anestesia"])){
            $qb ->andWhere("o.anestesia = :anestesia")
                ->setParameter("anestesia", $datos["anestesia"]);
            echo("entre en anestesia \n");
        }
        if(isset($datos["asa"])){
            $qb ->andWhere("o.asa = :asa")
                ->setParameter("asa", $datos["asa"]);
            echo("entre en asa \n");
        }

//        if(isset($datos["personal"])){
//            $qb ->andWhere("o.personal.dni = :personal")
//                ->setParameter("personal", $datos["personal"]);
//        }


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
//            $paginator = new Pagerfanta(new DoctrineORMAdapter($this->operacionEntre($datos["fechaIni"], $datos["fechaFin"]), false));
            $paginator = new Pagerfanta(new DoctrineORMAdapter($this->filtrarReservas($datos), false));
        }else{
            $paginator = new Pagerfanta(new DoctrineORMAdapter($this->queryLatest(), false));
        }
        $paginator->setMaxPerPage(self::NUMPAG);// llama a global en personal para cantidad de paginas Personal::NUM_ITEMS
        $paginator->setCurrentPage($page);

        return $paginator;
    }
}
