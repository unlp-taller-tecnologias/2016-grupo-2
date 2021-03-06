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
        $auxtotal = 0;
        $auxProgramada = 0;
        $auxAnestesia = 0;
        $auxGuardia = 0;
      
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
                    "class" => "btn btn-primary col-md-offset-5"
                ]
            ))
            ->getForm();

        $form->handleRequest($request);

        $totalprogramadas=0;
        $totalguardia=0;
        $totalanestesia=0;
        $total=0;
        foreach ($arregloservicios as $a) {
            $totalprogramadas = $totalprogramadas + $a[1];
            $totalguardia = $totalguardia + $a[2];
            $totalanestesia = $totalanestesia + $a[3];
            $total = $total + $a[4];

        }
        
        if ($form->isSubmitted() && $form->isValid()) {

            $datos = $form->getData();
            //aca tenes los datos que te llegan desde el form hay q hacer el filtrado

            $datos["fechaIni"] = str_replace('/', '-', $datos["fechaIni"]);
            $datos["fechaIni"]= date('Y-m-d H:i', strtotime($datos["fechaIni"]));

            $datos["fechaFin"] = str_replace('/', '-', $datos["fechaFin"]);
            $datos["fechaFin"]= date('Y-m-d H:i', strtotime($datos["fechaFin"]));

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
              $totalprogramadas=0;
              $totalguardia=0;
              $totalanestesia=0;
              $total=0;
              foreach ($arregloserviciosEntreFechas as $a) {
                  $totalprogramadas = $totalprogramadas + $a[1];
                  $totalguardia = $totalguardia + $a[2];
                  $totalanestesia = $totalanestesia + $a[3];
                  $total = $total + $a[4];
                
              }
                return $this->render('estadistica/index.html.twig', array(
                    'servicios' => $arregloserviciosEntreFechas,
                     'totalprogramadas' => $totalprogramadas,
                     'totalguardia' => $totalguardia,
                     'totalanestesia' => $totalanestesia,
                     'total' => $total,
                    'desde' => $datos["fechaIni"],
                    'hasta' => $datos["fechaFin"],
                    'form' => $form->createView(),
                ));
            
          }
            else {
                $error = "La fecha 'Desde' no puede ser mayor o igual a la fecha 'Hasta'.";
                return $this->render('estadistica/index.html.twig', array(
                'servicios' => $arregloservicios,
                'totalprogramadas' => $totalprogramadas,
                'totalguardia' => $totalguardia,
                'totalanestesia' => $totalanestesia,
                'total' => $total,
                'error' => $error,
                'form' => $form->createView(),
            ));
            }
          
        }


        return $this->render('estadistica/index.html.twig', array('servicios' => $arregloservicios,'totalprogramadas' => $totalprogramadas,
                     'totalguardia' => $totalguardia,
                     'totalanestesia' => $totalanestesia,
                     'total' => $total, 'form' => $form->createView()));
        
    }

    public function sacarInternados($reservas){
        $cant = 0;
            foreach ($reservas as $r) {
              if (!is_null($r->getOperacion())){
                  if (($r->getOperacion()->getInternado() == 1)) 
                  {
                    $cant++;
                  }    
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

            if (!is_null($r->getOperacion())) {
              if (!is_null($r->getOperacion()->getAnestesia())) 
              {
                $cant++;
              }
            }      
         }
         return $cant;
    }

/**
* Muestra la estadistica.
*
* @Route("/grafica", name="estadistica_grafica")
*
*/

    public function graficarEstadistica(){
        return $this->render('estadistica/grafico.html.twig', array(

        ));
    }
   
}
