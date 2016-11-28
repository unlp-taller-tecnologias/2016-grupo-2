<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Anestesia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ajax controller.
 *
 * @Route("/ajax")
 */
class AjaxController extends Controller
{

    /**
     * Ajax controller.
     *
     * @Route("/personal", name="ajax_personal")
     */
    public function datatableexampleAction(){

        $table = 'personal';
        $primaryKey = 'id';

        $columns = array(

            array( 'db' => 'nombre', 'dt' => 0 ),
            array( 'db' => 'apellido',  'dt' => 1 ),
            array( 'db' => 'genero',     'dt' => 2 ),
            array( 'db' => 'dni',     'dt' => 3 ),
            array( 'db' => 'edad',     'dt' => 4),
            array( 'db' => 'baja',   'dt' => 5),

        );

        $sql_details = array(
            'user' => 'hospital_rossi',
            'pass' => 'rossi123',
            'db'   => 'hospital_rossi',
            'host' => '127.0.0.1'
        );


        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP
         * server-side, there is no need to edit below this line.
         */

        require( '../SSP.php' );

        new Response (json_encode(
            \SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
        ));

    }


    /**     *
     * @Route("/ejemplo" , name="ajax_ejemplo")
     * @Method("POST")
     */
    public function ajaxsimple(Request $request){
        return new Response("alalalalalalla");

    }

    /**
     * @Route("/personal/list", name="ajax_personal_list")
     *
     */
    public function usersListAction(Request $request)
    {
        $get = $request->query->all();
        /* Array of database columns which should be read and sent back to DataTables. Use a space where
        * you want to insert a non-database field (for example a counter or static image)
        */
        $columns = array( 'nombre', 'apellido', 'dni', 'genero' ,'edad' , 'baja' );
        $get['columns'] = &$columns;
        $em = $this->getDoctrine()->getEntityManager();
        $rResult = $em->getRepository('AppBundle:Personal')->ajaxTable($get, true)->getArrayResult();
        /* Data set length after filtering */
                                         //$iFilteredTotal = count($rResult); **** lo comente yo
        /*
         * Output
         */
        $output = array(
            "sEcho" => intval($get['sEcho']),
            "iTotalRecords" => $em->getRepository('AppBundle:Personal')->getCount(),
            "iTotalDisplayRecords" => $em->getRepository('Entity')->getFilteredCount($get),
            "aaData" => array()
        );
        foreach($rResult as $aRow)
        {
            $row = array();
            for ( $i=0 ; $i<count($columns) ; $i++ ){
                if ( $columns[$i] == "version" ){
                    /* Special output formatting for 'version' column */
                    $row[] = ($aRow[ $columns[$i] ]=="0") ? '-' : $aRow[ $columns[$i] ];
                }elseif ( $columns[$i] != ' ' ){
                    /* General output */
                    $row[] = $aRow[ $columns[$i] ];
                }
            }
            $output['aaData'][] = $row;
        }
        unset($rResult);
        return new Response(
            json_encode($output)
        );
    }

}