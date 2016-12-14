<?php
namespace AppBundle\Repository;

use AppBundle\Controller\AjaxController;
use AppBundle\Entity\Paciente;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Config\Definition\Exception\Exception;

class PacienteRepository  extends EntityRepository
{
    const NUMPAG=40;
    /**
     * @return Query
     */
    public function queryLatest()
    {
        return $this->getEntityManager()
            ->createQuery('
                SELECT p
                FROM AppBundle:Paciente p     
            ');
    }

/**
* @return Query
*/
    public function filtrarPaciente($datos)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb ->select('p')
            ->from('AppBundle:Paciente', 'p');

        if(isset($datos["paciente"])&& !empty($datos["paciente"])){
            $qb
                ->where('p.id = :id')
                ->setParameter('id', $datos["paciente"]->getId());
        }else{

            if(isset($datos["nombre"]) && !empty($datos["nombre"])){
                $qb
                    ->where('p.nombre LIKE :nombre')
                    ->setParameter('nombre','%'.$datos["nombre"].'%');
            }

            if(isset($datos["apellido"])&& !empty($datos["apellido"])){
                $qb
                    ->andWhere('p.apellido LIKE :apellido')
                    ->setParameter('apellido','%'.$datos["apellido"].'%');
            }
//
//            if(isset($datos["edadmin"])&& !empty($datos["edadmin"])){
//                $qb
//                    ->andWhere('p.edadPersona >= :edadmin')
//                    ->setParameter('edadmin',$datos["edadmin"]);
//            }
//
//            if(isset($datos["edadmax"])&& !empty($datos["edadmax"])){
//                $qb
//                    ->andWhere('p.edadPersona <= :edadmax')
//                    ->setParameter('edadmax',$datos["edadmax"]);
//            }

        }

        return $qb->getQuery();
    }

    /**
     * @param int $page
     * @return Pagerfanta
     */
    public function findLatest($page = 1, $datos = null)
    {
        if($datos !== null)
        {
            $paginator = new Pagerfanta(new DoctrineORMAdapter($this->filtrarPaciente($datos), false));
        }else{
            $paginator = new Pagerfanta(new DoctrineORMAdapter($this->queryLatest(), false));
        }
        $paginator->setMaxPerPage(self::NUMPAG);// llama a global en personal para cantidad de paginas Personal::NUM_ITEMS
        $paginator->setCurrentPage($page);

        return $paginator;
    }
}
