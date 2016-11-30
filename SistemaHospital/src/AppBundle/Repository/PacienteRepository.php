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
     * @param int $page
     * @return Pagerfanta
     */
    public function findLatest($page = 1)
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($this->queryLatest(), false));
        $paginator->setMaxPerPage(50);// llama a global en personal para cantidad de paginas Personal::NUM_ITEMS
        $paginator->setCurrentPage($page);

        return $paginator;
    }
}
