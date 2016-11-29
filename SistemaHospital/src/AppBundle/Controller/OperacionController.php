<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Operacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
/**
 * Operacion controller.
 *
 * @Route("/operacion")
 */
class OperacionController extends Controller
{
    /**
     * Lists all operacion entities.
     *
     * @Route("/", name="operacion_index")
     * @Method({"GET","POST"})
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $operacions = $em->getRepository('AppBundle:Operacion')->findAll();

        $form = $this->createFormBuilder()
            ->add("fechaIni", "text",[
                'label' => 'Filtrar operaciones Desde',
                "attr" => [
                    "class" => "form-control datetimepicker"
                ]
            ])
            ->add("fechaFin", "text",[
                'label' => 'Hasta',
                "attr" => [
                    "class" => "form-control datetimepicker"
                ]
            ])
            ->add('save', SubmitType::class, array(
                'label' => 'Buscar operaciones',
                "attr" => [
                    "class" => "btn btn-primary col-md-2 col-md-offset-5"
                ]
            ))
            ->getForm();

        $form->handleRequest($request);

       
        if ($form->isSubmitted() && $form->isValid()) {

            $datos = $form->getData();
            //aca tenes los datos que te llegan desde el form hay q hacer el filtrado
            echo ($datos["fechaIni"]."  hasta: ". $datos["fechaFin"]);

            if ($datos ["fechaIni"] < $datos ["fechaFin"]) {

                $operacionesEntre = $this->operacionesEntre($datos["fechaIni"], $datos["fechaFin"]);
                
                return $this->render('operacion/index.html.twig', array(
                    'operacions' => $operacionesEntre,
                    'form' => $form->createView(),
                ));
            }
            else {
                echo ("(!!!! )ERROR, LA FECHA DE INICIO NO PUEDE SER MAYOR NI IGUAL A LA FECHA DE FIN");
                return $this->render('operacion/index.html.twig', array(
                'operacions' => $operacions,
                'form' => $form->createView(),
            ));
            }

        }

        return $this->render('operacion/index.html.twig', array(
            'operacions' => $operacions,
            'form' => $form->createView()
        ));
    }


      public function operacionesEntre($fechadesde, $fechahasta)
    {
        $resultado = array();  

        $em = $this->getDoctrine()->getManager();
        $operacions = $em->getRepository('AppBundle:Operacion')->findAll();
        $aux = $em->getRepository('AppBundle:Operacion')->find(1);
        echo($aux->getReserva()->getPaciente()->getId());
        $inicio = new \DateTime($fechadesde);
        $fin = new \DateTime($fechahasta);
        foreach ($operacions as $ope) {
            
            if (($ope->getReserva()->getFechaInicio() > $inicio) and
                ($ope->getReserva()->getFechaFin() < $fin)){
                array_push($resultado, $ope);
          }
        }

        return $resultado;
    }

    public function buscarReserva ($operacion){

       
        $em = $this->getDoctrine()->getManager();
        $reservas = $em->getRepository('AppBundle:Reserva')->findAll();
        foreach ($reservas as $r) {
            if ($r->getOperacion()->getId() == $id){
                return $r;
            }
        }
    }

    /**
     * Muestra la estadistica.
     
     */
        /*
     public function estadisticaIndex()
    {
        $em = $this->getDoctrine()->getManager();


        $query_string = "
          SELECT r as nombre, count (r) as suma
          FROM AppBundle\Entity\Reserva r 
          WHERE r.estado  = (SELECT e.id FROM AppBundle\Entity\Estado e WHERE e.tipo = 'FINALIZADA')
                
          GROUP BY r.servicio  
          ORDER BY r.servicio
          ";
        // agregar a la consulta:    
        // and r.operacion = (SELECT o.guardia FROM AppBundle\Entity\Operacion o WHERE o.guardia = 1)
        $query = $em->createQuery($query_string);
        $reservas= $query->getResult();

         $query_string = "
          SELECT r 
          FROM AppBundle\Entity\Reserva r
          WHERE r.estado  = (SELECT e.id FROM AppBundle\Entity\Estado e WHERE e.tipo = 'FINALIZADA')
          ORDER BY r.servicio
          ";

        $query = $em->createQuery($query_string);
        $res= $query->getResult();

        $anestesia=0;
        $sinanestesia=0;
        $arreglo = array();
        foreach ($res as $r) {

            if (is_null($r->getOperacion()->getAnestesia())) {
                $sinanestesia= $sinanestesia + 1;
            }
            else {
                $anestesia= $anestesia + 1;
            }

        }

        return $this->render('operacion/estadistica.html.twig', array('reservas' => $reservas, 'anestesia' => $anestesia, 'sinanestesia' => $sinanestesia));
    }*/

    /**
     * Creates a new operacion entity.
     *
     * @Route("/new", name="operacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $operacion = new Operacion();
        $form = $this->createForm('AppBundle\Form\OperacionType', $operacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($operacion);
            $em->flush($operacion);

            return $this->redirectToRoute('operacion_show', array('id' => $operacion->getId()));
        }

        return $this->render('operacion/new.html.twig', array(
            'operacion' => $operacion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a operacion entity.
     *
     * @Route("/{id}", name="operacion_show")
     * @Method("GET")
     */
    public function showAction(Operacion $operacion)
    {
        $deleteForm = $this->createDeleteForm($operacion);

        return $this->render('operacion/show.html.twig', array(
            'operacion' => $operacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing operacion entity.
     *
     * @Route("/{id}/edit", name="operacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Operacion $operacion)
    {
        $deleteForm = $this->createDeleteForm($operacion);
        $editForm = $this->createForm('AppBundle\Form\OperacionType', $operacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('operacion_edit', array('id' => $operacion->getId()));
        }

        return $this->render('operacion/edit.html.twig', array(
            'operacion' => $operacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a operacion entity.
     *
     * @Route("/{id}", name="operacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Operacion $operacion)
    {
        $form = $this->createDeleteForm($operacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($operacion);
            $em->flush($operacion);
        }

        return $this->redirectToRoute('operacion_index');
    }

    /**
     * Creates a form to delete a operacion entity.
     *
     * @param Operacion $operacion The operacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Operacion $operacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('operacion_delete', array('id' => $operacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
