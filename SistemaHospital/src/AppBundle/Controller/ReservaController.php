<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reserva;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $form = $this->createFormBuilder()
            ->add("fechaIni", "text", [
                'label' => 'Filtrar reservas Desde',
                "attr" => [
                    "class" => "form-control datetimepicker"
                ]
            ])
            ->add("fechaFin", "text", [
                'label' => 'Hasta',
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

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $page=1;//para que reinicie la paginacion en la pagina 1 si es que se enviaron datos al formulario
            $datos = $form->getData();

            if ($datos ["fechaIni"] < $datos ["fechaFin"]) {

                //$reservasEntre = $this->reservasEntre($datos["fechaIni"], $datos["fechaFin"]);

                $reservas = $em->getRepository(Reserva::class)->findLatest($page,$datos);

                return $this->render('reserva/index.html.twig', array(
                    'reservas' => $reservas,
                    'form' => $form->createView(),
                    //'paginacion' => false
                ));
            } else {
                echo("(!!!! )ERROR, LA FECHA DE INICIO NO PUEDE SER MAYOR NI IGUAL A LA FECHA DE FIN");
                $reservas = $em->getRepository(Reserva::class)->findLatest($page,null);
                return $this->render('reserva/index.html.twig', array(
                    'reservas' => $reservas,
                    'form' => $form->createView(),
                ));
            }

        }
        $reservas = $em->getRepository(Reserva::class)->findLatest($page,null);

        return $this->render('reserva/index.html.twig', array(
            'reservas' => $reservas,
            'form' => $form->createView(),
            //'paginacion' => true
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
