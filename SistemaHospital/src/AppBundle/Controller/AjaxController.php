<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Anestesia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use SSP;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Ajax controller.
 *
 * @Route("/ajax")
 */
class AjaxController extends Controller
{

    /**     *
     * @Route("/ejemplo" , name="ajax_ejemplo")
     * @Method("POST")
     */
    public function ajaxsimple(){

        $datos=array();
        $datos["fechaDesde"]=$_REQUEST["fechaDesde"];
        $datos["fechaHasta"]=$_REQUEST["fechaHasta"];
        $respuesta= $this->procesarDatos($datos);

        return new Response($respuesta);
    }

    public function procesarDatos($datos)
    {
        if(isset($datos["fechaDesde"]) && isset($datos["fechaHasta"]) ){
            //$listaOperacion= $this->listarEntreFechas('AppBundle:Operacion',$datos["fechaDesde"],$datos["fechaHasta"]);
            $date1 = new \DateTime($datos["fechaDesde"]);
            $date2 = new \DateTime($datos["fechaHasta"]);
            $dias= $date2->diff($date1)->format("%a") + 1;

            $array = array();
            $auxFecha=$datos["fechaDesde"];

            for ($i = 0; $i < $dias; $i++)
            {
                //LISTA DE COMPRAS Y VENTAS EN UNA FECHA --> no va a la base de datos
                $listaOpeXDia= $this->listarEntreFechas('AppBundle:Operacion',$auxFecha,$auxFecha);
                //AUMENTAR UN DIA!!!
                $auxFecha = new \DateTime($auxFecha);
                $auxFecha->modify('+1 day');
                $auxFecha= $auxFecha->format('Y-m-d');

                $cantidad=count($listaOpeXDia);

                array_push($array, $cantidad);
            }

            return json_encode($array) ;
        }else{
            return null;
        }
    }


    public function listarEntreFechas($model, $fecha1, $fecha2)
    {

        $listado=null;
        $fecha1= new \DateTime($fecha1." 00:00:00");
        $fecha2= new \DateTime($fecha2." 23:59:59");

        $qb = $this->getDoctrine()->getEntityManager()->createQueryBuilder();
        $qb
            ->select('c')
            ->from('AppBundle:Operacion', 'c')
            ->join('c.reserva', 'r')
            ->where('r.fecha_inicio BETWEEN :firstDate AND :lastDate')
            ->setParameter('firstDate', $fecha1)
            ->setParameter('lastDate',  $fecha2)
        ;
        $listado = $qb->getQuery()->execute();
        return $listado;
    }
}