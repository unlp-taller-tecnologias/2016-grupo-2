<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reserva;
use AppBundle\Entity\Quirofano;
use AppBundle\Entity\Operacion;
use AppBundle\Entity\Sangre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Reserva controller.
 *
 *
 */
class ReservaController extends Controller
{
    /**
     * Lists all reserva entities.
     *
     * @Route("/",defaults={"page": 1},name="reserva_index")
     * @Route("/page/{page}", requirements={"page": "[1-9]\d*"}, name="reserva_index_paginated")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request, $page)

    {

        $em = $this->getDoctrine()->getManager();

        $form2 = $this->createForm('AppBundle\Form\FechaPendientesType');
        $form = $this->createForm('AppBundle\Form\FiltroReservaType');


        $form->handleRequest($request);
        $form2->handleRequest($request);

        $hoy = new \DateTime ("now");
        $year=$hoy->format("Y");
        $month=$hoy->format("m");
        $day=$hoy->format("d");
        $fecha1= $year."-".$month."-".$day." 00:00:00";
        $fecha2= $year."-".$month."-".$day." 23:59:50";
        $reservasPen = $em->getRepository(Reserva::class)->findPendientes($fecha1,$fecha2);

        if ($form->isSubmitted() && $form->isValid()) {
            $page=1;//para que reinicie la paginacion en la pagina 1 si es que se enviaron datos al formulario
            $datos = $form->getData();

            if(isset($datos["fechaIni"]) &&  isset($datos["fechaFin"])){
                $datos["fechaIni"] = str_replace('/', '-', $datos["fechaIni"]);
                $datos["fechaIni"]= date('Y-m-d H:i', strtotime($datos["fechaIni"]));

                $datos["fechaFin"] = str_replace('/', '-', $datos["fechaFin"]);
                $datos["fechaFin"]= date('Y-m-d H:i', strtotime( $datos["fechaFin"]));
            }

            $reservas = $em->getRepository(Reserva::class)->findLatest($page,$datos);

            return $this->render('reserva/index.html.twig', array(
                'reservas' => $reservas,
                'form' => $form->createView(),
                'form2'=> $form2->createView(),
                'reservasPen' => $reservasPen,
            ));


        }else if($form2->isSubmitted() && $form2->isValid()){
            $dataPendientes= $form2->getData();
            if(isset($dataPendientes["fechaPend"])){
                $dataPendientes["fechaPend"] = str_replace('/', '-', $dataPendientes["fechaPend"]);
                $fecha1= date('Y-m-d H:i:s', strtotime($dataPendientes["fechaPend"]));

                $dataPendientes["fechaPend"] = str_replace('/', '-', $dataPendientes["fechaPend"]);
                $fecha2= date('Y-m-d 23:59:59', strtotime( $dataPendientes["fechaPend"]));

                $reservasPen = $em->getRepository(Reserva::class)->findPendientes($fecha1,$fecha2);
            }
        }
        

        $reservas = $em->getRepository(Reserva::class)->findLatest($page,null);
        return $this->render('reserva/index.html.twig', array(
            'reservas' => $reservas,
            'form' => $form->createView(),
            'form2'=> $form2->createView(),
            'reservasPen' => $reservasPen,
        ));

    }




    /**
     * Creates a new reserva entity.
     *
     * @Route("/new", name="reserva_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
         $form = $this->createFormBuilder()
           ->add('quirofano', 'entity', array(
                'class' => 'AppBundle:Quirofano',
                'property'     => 'getNombre',
                'label' => 'Quirófano',
                "attr" => [
                    "class" => "form-control"
                ]
            ))
            ->add("fechaquirofano", "text",[
                'label' => 'Fecha',
                "attr" => [
                    "class" => "form-control datetimepicker"
                ]
            ])
            ->getForm();

         $form->handleRequest($request);

         $form2 = $this->createFormBuilder()
            ->add("numero_reserva", "number",[
                'label' => 'Numero reserva',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add("fecha_inicio", "text",[
                'label' => 'Fecha y Hora de Inicio',
                "attr" => [
                    "class" => "form-control datetimepicker"
                ]
            ])
            ->add("fecha_fin", "text",[
                'label' => 'Fecha y Hora de Finalización',
                "attr" => [
                    "class" => "form-control datetimepicker"
                ]
            ])
            ->add("paciente", "choice",[
                'label' => 'Paciente',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            /*->add('agregarpaciente', ButtonType::class, array(
                 'label' => 'Agregar un nuevo paciente',
                "attr" => [
                    "class" => "form-control"
                ]
            ))*/

            ->add('estado', 'entity', array(
                'class' => 'AppBundle:Estado',
                'property'     => 'getTipo',
                'label' => 'Estado de la reserva',
                "attr" => [
                    "class" => "form-control"
                ]
            ))
            ->add('paciente', 'entity', array(
                'class' => 'AppBundle:Paciente',
                'property'     => 'getNombreyApellido',
                'label' => 'Paciente',
                "attr" => [
                    "class" => "form-control"
                ]
            ))
            ->add('servicio', 'entity', array(
                'class' => 'AppBundle:Servicio',
                'property'     => 'getTipo',
                'label' => 'Servicio',
                "attr" => [
                    "class" => "form-control"
                ]
            ))
            ->add('quirofano', 'entity', array(
                'class' => 'AppBundle:Quirofano',
                'property'     => 'getNombre',
                'label' => 'Quirófano',
                "attr" => [
                    "class" => "form-control"
                ]
            ))
           ->add('sangre', 'entity', array(
                'class' => 'AppBundle:Sangre',
                'property'     => 'getNombre',
                'label' => 'Sangre',
                "attr" => [
                    "class" => "form-control"
                ]
            ))
           ->add('asa', 'entity', array(
                'class' => 'AppBundle:Asa',
                'property'     => 'getGrado',
                'label' => 'Asa',
                "attr" => [
                    "class" => "form-control"
                ]
            ))
           ->add('Anestesia', 'entity', array(
                'class' => 'AppBundle:Anestesia',
                'property'     => 'getTipo',
                'label' => 'Anestesia',
                "attr" => [
                    "class" => "form-control"
                ]
            ))
            ->add("diagnostico", "text",[
                'label' => 'Diagnostico',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
             ->add("habitacion", "text",[
                'label' => 'Habitacion',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
              ->add("observaciones", "text",[
                'label' => 'Observaciones',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add("cirugia", "text",[
                'label' => 'Cirugia',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
             ->add('Internado', ChoiceType::class, array(
                'choices'  => array(
                    1 => 'Si',
                    0 => 'No',
                ),
                "attr" => [
                    "class" => "form-control"
                ]
            ))
            ->add('TiempoQuirurgico', ChoiceType::class, array(
                'choices'  => array(
                   "Corto" => 'Corto',
                    "Medio" => 'Medio',
                    "Largo" => 'Largo',
                    "Muy Largo" => 'Muy Largo',
                ),
                "attr" => [
                    "class" => "form-control"
                ]
            ))
            ->getForm();

        $form2->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $datosQuirofano = $form->getData();

            $quirofano = $datosQuirofano['quirofano'];
            $date =  $datosQuirofano['fechaquirofano'];

            $turnosquirofano = $this->getTurnosQuirofano($quirofano->getId(), $date);

              return $this->render('reserva/disponibilidad_quirofano.html.twig', array(
            'quirofano' => $quirofano,
             'turnos' => $turnosquirofano,
             'fecha' => $datosQuirofano['fechaquirofano'],
             'total' => count($turnosquirofano)
        ));
        }
      
        if ($form2->isSubmitted() && $form2->isValid()){
                
                $datos = $form2->getData();

                $operacion = new Operacion();
                $operacion->setDiagnostico($datos["diagnostico"]);
                $operacion->setHabitacion($datos["habitacion"]);
                $operacion->setObservaciones($datos["observaciones"]);
                $operacion->setInternado($datos["Internado"]);
                $operacion->setCirujia($datos["cirugia"]);
                $operacion->setTq($datos["TiempoQuirurgico"]);
                $operacion->setBaja(0); //Se setea en 0 por defecto siempre.
                $operacion->setSangre($datos["sangre"]);
                $operacion->setAsa($datos["asa"]);
                $operacion->setAnestesia($datos["Anestesia"]);
                $em = $this->getDoctrine()->getManager();
                $em->persist($operacion);
                $em->flush($operacion);

                $reserva = new Reserva();
                $reserva->setNumeroReserva($datos['numero_reserva']);
                $reserva->setBaja(0);

                $inicio = new \DateTime($datos['fecha_inicio']);
                 $fin = new \DateTime($datos['fecha_fin']);

                $reserva->setFechaInicio($inicio);
                $reserva->setFechaFin($fin);
                $reserva->setPaciente($datos['paciente']);
                $reserva->setServicio($datos['servicio']);
                $reserva->setEstado($datos['estado']);
                $reserva->setQuirofano($datos['quirofano']);
                $reserva->setOperacion($operacion);
                $em->persist($reserva);
                $em->flush($reserva);


              return $this->redirectToRoute('reserva_show', array('id' => $reserva->getId()));
        }

       return $this->render('reserva/new.html.twig', array(
            'form' => $form->createView(),
            'form2' => $form2->createView(),
        
        ));
    }

    /**
     * Finds and displays a reserva entity.
     *
     * @Route("/{id}/show", name="reserva_show")
     * @Method("GET")
     */
    public function showAction(Reserva $reserva)
    {
        $deleteForm = $this->createDeleteForm($reserva);

        return $this->render('reserva/show.html.twig', array(
            'reserva' => $reserva,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function getTurnosQuirofano($quirofano, $fecha){
     

        $em = $this->getDoctrine()->getManager();

        $turnos= array();

          $query_string = "
          SELECT r
          FROM AppBundle\Entity\Reserva r 
          WHERE r.quirofano = :quirofano and r.fecha_inicio = :fecha
          ORDER by r.fecha_inicio
          ";
        $query = $em->createQuery($query_string);

        $query->setParameter('quirofano',$quirofano);
        $query->setParameter('fecha',new \DateTime($fecha));

        return $query->getResult();

        
        }
    /**
     * Displays a form to edit an existing reserva entity.
     *
     * @Route("/{id}/edit", name="reserva_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Reserva $reserva)
    {
        $deleteForm = $this->createDeleteForm($reserva);
        $editForm = $this->createForm('AppBundle\Form\ReservaType', $reserva);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reserva_edit', array('id' => $reserva->getId()));
        }

        return $this->render('reserva/edit.html.twig', array(
            'reserva' => $reserva,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Cancela una reserva .
     *
     * @Route("/{id}/cancel", name="reserva_cancel")
     *
     */
    public function cancelAction(Reserva $reserva)
    {

        $em = $this->getDoctrine()->getManager();

        $estado = $this->getDoctrine()->getRepository('AppBundle:Estado')->findOneBytipo('cancelada');
        $reserva->setEstado($estado);
        $reserva->setBaja(true);
        $em->persist($reserva);
        $em->flush();

        return $this->redirectToRoute('reserva_index');
    }


    /**
     * Deletes a reserva entity.
     *
     * @Route("/{id}", name="reserva_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Reserva $reserva)
    {
        $form = $this->createDeleteForm($reserva);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reserva);
            $em->flush($reserva);
        }

        return $this->redirectToRoute('reserva_index');
    }

    /**
     * Creates a form to delete a reserva entity.
     *
     * @param Reserva $reserva The reserva entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reserva $reserva)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reserva_delete', array('id' => $reserva->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
