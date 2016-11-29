<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use AppBundle\Entity\Operacion;

/**
 * Estadistica controller.
 *
 * @Route("operacion/estadistica")
 */
class EstadisticaController extends Controller
{
    
    /**
     * Muestra la estadistica.
     *
     * @Route("/", name="estadistica_index")
     * 
     */

     public function estadisticaIndex(Request $request)
    {
      
        $em = $this->getDoctrine()->getManager();

         $arregloservicios = array();
        $servicios = $em->getRepository('AppBundle:Servicio')->findAll();
        foreach ($servicios as $s) {
          $reservas = $this->reservasFinalizadas ($s->getReservas());
          $cantTotal = count($reservas);
          $cantInternados= $this->sacarInternados($reservas);
          $cantAnestesia= $this->reservasConAnestesia($reservas);
          $cantGuardias = $cantTotal - $cantInternados;
         
          $arregloServicio = array();
          array_push($arregloServicio, $s->getTipo(), $cantInternados, $cantGuardias, $cantAnestesia, $cantTotal );
          array_push($arregloservicios, $arregloServicio);

        }

        $form = $this->createFormBuilder()
            ->add("fechaIni", "text",[
                "label" => 'Generar estadística Desde',
                "attr" => [
                    "class" => "form-control datetimepicker"
                ]
            ])
            ->add("fechaFin", "text",[
                "label" => 'Hasta',
                "attr" => [
                    "class" => "form-control datetimepicker"
                ]
            ])
            ->add('save', SubmitType::class, array(
                'label' => 'Realizar estadística',
                "attr" => [
                    "class" => "btn btn-primary col-md-2 col-md-offset-5"
                ]
            ))
            ->getForm();

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $datos = $form->getData();
            //aca tenes los datos que te llegan desde el form hay q hacer el filtrado
           

            if ($datos ["fechaIni"] < $datos ["fechaFin"]) {

                $arregloserviciosEntreFechas = array();
                $servicios = $em->getRepository('AppBundle:Servicio')->findAll();

                foreach ($servicios as $s) {
                  $reservasDelServicio = $this->reservasFinalizadas ($s->getReservas());
                  $reservas= $this->entreFechas($reservasDelServicio, $datos["fechaIni"], $datos["fechaFin"]);
                  $cantTotal = count($reservas);
                  $cantInternados= $this->sacarInternados($reservas);
                  $cantAnestesia= $this->reservasConAnestesia($reservas);
                  $cantGuardias = $cantTotal - $cantInternados;
         
                  $arregloServicio = array();
                  array_push($arregloServicio, $s->getTipo(), $cantInternados, $cantGuardias, $cantAnestesia, $cantTotal );
                  array_push($arregloserviciosEntreFechas, $arregloServicio);

              }
                return $this->render('estadistica/index.html.twig', array(
                    'servicios' => $arregloserviciosEntreFechas,
                    'form' => $form->createView(),
                ));
            
          }
            else {
                echo ("(!!!! )ERROR, LA FECHA DE INICIO NO PUEDE SER MAYOR NI IGUAL A LA FECHA DE FIN");
                return $this->render('estadistica/index.html.twig', array(
                'servicios' => $arregloservicios,
                'form' => $form->createView(),
            ));
            }
          
        }
        
        return $this->render('estadistica/index.html.twig', array('servicios' => $arregloservicios, 'form' => $form->createView()));
        
    }

    public function sacarInternados($reservas){
        $cant = 0;
        foreach ($reservas as $r) {
            if (($r->getOperacion()->getInternado() == 1)) 
            {
              $cant++;
            }      
         }
         return $cant;
    }

    public function reservasFinalizadas($reservas){
        $resultado = array();
        foreach ($reservas as $r) {
            if ($r->getEstado()->getTipo() == 'FINALIZADA') 
            {
              array_push($resultado, $r);
            }      
         }
         return $resultado;
    }

    public function entreFechas ($reservas, $fechaini, $fechafin) {

      $inicio = new \DateTime($fechaini);
      $fin = new \DateTime($fechafin);

      $resultado = array();
      foreach ($reservas as $r) {
            $reservainicio = $r->getFechaInicio();
            $reservafin = $r->getFechaFin();

            if (($reservainicio > $inicio) and ($reservafin < $fin)){
            array_push($resultado, $r);
            }
            
      }

      return $resultado;


    }

    public function reservasConAnestesia ($reservas){
         $cant = 0;
        foreach ($reservas as $r) {
            if (!is_null($r->getOperacion()->getAnestesia())) 
            {
              $cant++;
            }      
         }
         return $cant;
    }

   
}
