<?php
namespace AppBundle\Repository;

use AppBundle\Controller\AjaxController;
use AppBundle\Entity\Personal;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Config\Definition\Exception\Exception;

class PersonalRepository  extends EntityRepository
{
    /**
     * @param array $get
     * @param bool $flag
     * @return array|\Doctrine\ORM\Query
     */
//    public function ajaxTable(array $get, $flag = false){
//
//
//        /* Indexed column (used for fast and accurate table cardinality) */
//        $alias = 'a';
//        /* DB table to use */
//        $tableObjectName = 'AppBundle:Personal';
//        /**
//         * Set to default
//         */
//        if(!isset($get['columns']) || empty($get['columns']))
//            $get['columns'] = array('id');
//        $aColumns = array();
//        foreach($get['columns'] as $value) $aColumns[] = $alias .'.'. $value;
//        $cb = $this->getEntityManager()
//            ->getRepository($tableObjectName)
//            ->createQueryBuilder($alias)
//            ->select(str_replace(" , ", " ", implode(", ", $aColumns)));
//        if ( isset( $get['iDisplayStart'] ) && $get['iDisplayLength'] != '-1' ){
//            $cb->setFirstResult( (int)$get['iDisplayStart'] )
//                ->setMaxResults( (int)$get['iDisplayLength'] );
//        }
//        /*
//         * Ordering
//         */
//        if ( isset( $get['iSortCol_0'] ) ){
//            for ( $i=0 ; $i<intval( $get['iSortingCols'] ) ; $i++ ){
//                if ( $get[ 'bSortable_'.intval($get['iSortCol_'.$i]) ] == "true" ){
//                    $cb->orderBy($aColumns[ (int)$get['iSortCol_'.$i] ], $get['sSortDir_'.$i]);
//                }
//            }
//        }
//        /*
//           * Filtering
//           * NOTE this does not match the built-in DataTables filtering which does it
//           * word by word on any field. It's possible to do here, but concerned about efficiency
//           * on very large tables, and MySQL's regex functionality is very limited
//           */
//        if ( isset($get['sSearch']) && $get['sSearch'] != '' ){
//            $aLike = array();
//            for ( $i=0 ; $i<count($aColumns) ; $i++ ){
//                if ( isset($get['bSearchable_'.$i]) && $get['bSearchable_'.$i] == "true" ){
//                    $aLike[] = $cb->expr()->like($aColumns[$i], '\'%'. $get['sSearch'] .'%\'');
//                }
//            }
//            if(count($aLike) > 0) $cb->andWhere(new Expr\Orx($aLike));
//            else unset($aLike);
//        }
//        /*
//         * SQL queries
//         * Get data to display
//         */
//        $query = $cb->getQuery();
//        if($flag)
//            return $query;
//        else
//            return $query->getResult();
//    }
    /**
     * @return int
     */
//    public function getCount(){
//        $aResultTotal = $this->getEntityManager()
//            ->createQuery('SELECT COUNT(a) FROM AppBundle:Personal a')
//            ->setMaxResults(1)
//            ->getResult();
//        return $aResultTotal[0][1];
//    }
//    public function getFilteredCount(array $get)
//    {
//        /* Indexed column (used for fast and accurate table cardinality) */
//        $alias = 'a';
//        /* DB table to use */
//        $tableObjectName = 'AppBundle:Personal';
//        /**
//         * Set to default
//         */
//        if(!isset($get['columns']) || empty($get['columns']))
//            $get['columns'] = array('id');
//        $aColumns = array();
//        foreach($get['columns'] as $value) $aColumns[] = $alias .'.'. $value;
//
//        $cb = $this->getEntityManager()
//            ->getRepository($tableObjectName)
//            ->createQueryBuilder($alias)
//            ->select("count(a.id)");
//
//        /*
//        * Filtering
//        * NOTE this does not match the built-in DataTables filtering which does it
//        * word by word on any field. It's possible to do here, but concerned about efficiency
//        * on very large tables, and MySQL's regex functionality is very limited
//        */
//        if ( isset($get['sSearch']) && $get['sSearch'] != '' ){
//            $aLike = array();
//            for ( $i=0 ; $i<count($aColumns) ; $i++ ){
//                if ( isset($get['bSearchable_'.$i]) && $get['bSearchable_'.$i] == "true" ){
//                    $aLike[] = $cb->expr()->like($aColumns[$i], '\'%'. $get['sSearch'] .'%\'');
//                }
//            }
//            if(count($aLike) > 0) $cb->andWhere(new Expr\Orx($aLike));
//            else unset($aLike);
//        }
//
//        /*
//         * SQL queries
//         * Get data to display
//         */
//        $query = $cb->getQuery();
//        $aResultTotal = $query->getResult();
//        return $aResultTotal[0][1];
//    }


    /**
     * @return Query
     */
    public function queryLatest()
    {
        return $this->getEntityManager()
            ->createQuery('
                SELECT p
                FROM AppBundle:Personal p     
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
