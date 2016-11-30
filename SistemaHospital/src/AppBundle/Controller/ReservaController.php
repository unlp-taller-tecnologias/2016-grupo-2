<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reserva;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Acl\Exception\Exception;

/**
 * Reserva controller.
 *
 * @Route("/reserva")
 */
class ReservaController extends Controller 
{
    /**
     * Lists all reserva entities.
     *     
     * @Route("/",defaults={"page": 1},name="reserva_index")
     * @Route("/page/{page}", requirements={"page": "[1-9]\d*"}, name="reserva_index_paginated")
     * @Method({"GET","POST"})
     */
    public function indexAction( Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $reservas = $em->getRepository('AppBundle:Reserva')->findAll();
        //$reservas = $em->getRepository('AppBundle:Reserva')->findLatest($page);




               $form = $this->createFormBuilder()
                    ->add("fechaIni", "text",[
                        'label' => 'Filtrar reservas Desde',
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
                        'label' => 'Buscar reservas',
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

                                $reservasEntre = $this->reservasEntre($datos["fechaIni"], $datos["fechaFin"]);
                                echo (count($reservas));

                                return $this->render('reserva/index.html.twig', array(
                                    'reservas' => $reservasEntre,
                                    'form' => $form->createView(),
                                ));
                            }
                            else {
                                echo ("(!!!! )ERROR, LA FECHA DE INICIO NO PUEDE SER MAYOR NI IGUAL A LA FECHA DE FIN");
                                return $this->render('reserva/index.html.twig', array(
                                'reservas' => $reservas,
                                'form' => $form->createView(),
                            ));
                            }

                        }

    return $this->render('reserva/index.html.twig', array(
                'reservas' => $reservas,
                 'form' => $form->createView(),
            ));

    }

    public function reservasEntre($fechadesde, $fechahasta)
    {
        $em = $this->getDoctrine()->getManager();
        $query_string = "
          SELECT r
          FROM AppBundle\Entity\Reserva r
          where r.fecha_inicio BETWEEN :fechaDesde and :fechaHasta";

        $query= $em->createQuery($query_string);
        $query->setParameter('fechaDesde', new \DateTime($fechadesde));
        $query->setParameter('fechaHasta', new \DateTime($fechahasta));

        return $query->getResult();
        
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
            ->getForm()
        ;
    }
}
