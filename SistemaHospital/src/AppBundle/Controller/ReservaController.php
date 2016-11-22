<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reserva;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Reserva controller.
 *
 * @Route("reserva")
 */
class ReservaController extends Controller 
{
    /**
     * Lists all reserva entities.
     *
     * @Route("/", name="reserva_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reservas = $em->getRepository('AppBundle:Reserva')->findAll();

        $form = $this->createFormBuilder()
            ->add("fechaIni", "text",[
                "attr" => [
                    "class" => "form-control datetimepicker"
                ]
            ])
            ->add("fechaFin", "text",[
                "attr" => [
                    "class" => "form-control datetimepicker"
                ]
            ])
            ->add('save', SubmitType::class, array(
                'label' => 'Buscar reservas',
                "attr" => [
                    "class" => "btn btn-primary col-md-2 col-md-offset-5"
                ]
            ))
            ->getForm();


        return $this->render('reserva/index.html.twig', array(
            'reservas' => $reservas,
            'form' => $form->createView(),
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
        $reserva = new Reserva();
        $form = $this->createForm('AppBundle\Form\ReservaType', $reserva);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reserva);
            $em->flush($reserva);

            return $this->redirectToRoute('reserva_show', array('id' => $reserva->getId()));
        }

        return $this->render('reserva/new.html.twig', array(
            'reserva' => $reserva,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a reserva entity.
     *
     * @Route("/{id}", name="reserva_show")
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
     * Lista las reservas entre dos fechas .
     *
     * @Route("/", name="reserva_entre")
     * @Method("GET")
     */
    public function reservasEntre($fechadesde, $fechahasta)
    {
        $em = $this->getDoctrine()->getManager();
        $query_string = "
          SELECT p
          FROM AppBundle\Entity\Reserva r
          where r.fecha_inicio BETWEEN :fechaDesde and :fechaHasta";

        $query= $em->createQuery($query_string);
        $query->setParameter('fechaDesde',$fechadesde);
        $query->setParameter('fechaHasta',$fechahasta);

        return $this->render('reserva/index.html.twig', array(
            'reservas' => $reservas,
        ));
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
            ->getForm()
        ;
    }
}
