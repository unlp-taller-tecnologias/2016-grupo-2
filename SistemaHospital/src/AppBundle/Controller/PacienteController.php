<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Paciente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Paciente controller.
 *
 * @Route("paciente")
 */
class PacienteController extends Controller
{
    /**
     * Lists all paciente entities.
     *
     * @Route("/",defaults={"page": 1}, name="paciente_index")
     * @Route("/page/{page}", requirements={"page": "[1-9]\d*"}, name="paciente_index_paginated")
     * @Method("GET")
     */
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $pacientes = $em->getRepository('AppBundle:Paciente')->findLatest($page);

        return $this->render('paciente/index.html.twig', array(
            'pacientes' => $pacientes,
        ));
    }

    /**
     * Creates a new paciente entity.
     *
     * @Route("/new", name="paciente_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $paciente = new Paciente();
        $form = $this->createForm('AppBundle\Form\PacienteType', $paciente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $formnew = $form->getData();
            $datos = array('nombre' => $formnew->getNombre(), 'apellido' => $formnew->getApellido(), 'dni' => $formnew->getDni(),
                'edad' => $formnew->getEdad(), 'genero' => $formnew->getGenero());

            if($this->procesardatos($datos,'paciente/new.html.twig',$paciente,$form->createView(),false,false)){
                return $this->procesardatos($datos,'paciente/new.html.twig',$paciente,$form->createView(),false,false);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($paciente);
            $em->flush($paciente);

            return $this->redirectToRoute('paciente_show', array('id' => $paciente->getId(), 'exito' => 'new'));

        }

        return $this->render('paciente/new.html.twig', array(
            'paciente' => $paciente,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new paciente entity.
     *
     * @Route("/newParaReserva", name="paciente_agregarpaciente_reserva")
     * @Method({"GET", "POST"})
     */
    public function newActionInReserva(Request $request)
    {
        $paciente = new Paciente();
        $form = $this->createForm('AppBundle\Form\PacienteInReservaType', $paciente);
        $form->handleRequest($request);

       

        if ($form->isSubmitted() && $form->isValid()) {
            $formnew = $form->getData();
            $datos = array('nombre' => $formnew->getNombre(), 'apellido' => $formnew->getApellido(), 'dni' => $formnew->getDni(),
                'edad' => $formnew->getEdad(), 'genero' => $formnew->getGenero());

            if($this->procesardatos($datos,'paciente/newInReserva.html.twig',$paciente,$form->createView(),false,false)){
                return $this->procesardatos($datos,'paciente/newInReserva.html.twig',$paciente,$form->createView(),false,false);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($paciente);
            $em->flush($paciente);

            return $this->redirectToRoute('reserva_new');

        }

        return $this->render('paciente/newInReserva.html.twig', array(
            'paciente' => $paciente,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new paciente entity.
     *
     * @Route("/newParaOperacion", name="paciente_agregarpaciente_operacion")
     * @Method({"GET", "POST"})
     */
    public function newActionInOperacion(Request $request)
    {
        $paciente = new Paciente();
        $form = $this->createForm('AppBundle\Form\PacienteType', $paciente);
        $form->handleRequest($request);

       

        if ($form->isSubmitted() && $form->isValid()) {
            $formnew = $form->getData();
            $datos = array('nombre' => $formnew->getNombre(), 'apellido' => $formnew->getApellido(), 'dni' => $formnew->getDni(),
                'edad' => $formnew->getEdad(), 'genero' => $formnew->getGenero());

            if($this->procesardatos($datos,'paciente/newInOperacion.html.twig',$paciente,$form->createView(),false,false)){
                return $this->procesardatos($datos,'paciente/newInOperacion.html.twig',$paciente,$form->createView(),false,false);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($paciente);
            $em->flush($paciente);

            return $this->redirectToRoute('operacion_new');

        }

        return $this->render('paciente/newInOperacion.html.twig', array(
            'paciente' => $paciente,
            'form' => $form->createView(),
        ));
    }


    /**
     * Finds and displays a paciente entity.
     *
     * @Route("/{id}", name="paciente_show")
     * @Method("GET")
     */
    public function showAction(Paciente $paciente)
    {
        $deleteForm = $this->createDeleteForm($paciente);

        return $this->render('paciente/show.html.twig', array(
            'paciente' => $paciente,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing paciente entity.
     *
     * @Route("/{id}/edit", name="paciente_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Paciente $paciente)
    {
        $deleteForm = $this->createDeleteForm($paciente);
        $editForm = $this->createForm('AppBundle\Form\PacienteType', $paciente);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $form = $editForm->getData();
            $datos = array('nombre' => $form->getNombre(), 'apellido' => $form->getApellido(), 'dni' => $form->getDni(),
                'edad' => $form->getEdad(), 'genero' => $form->getGenero());

            if($this->procesardatos($datos,'paciente/edit.html.twig',$paciente,false,$editForm->createView(),$deleteForm->createView())){
                return $this->procesardatos($datos,'paciente/edit.html.twig',$paciente,false,$editForm->createView(),$deleteForm->createView());
            }

            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('paciente_show', array('id' => $paciente->getId(), 'exito' => 'edit'));

        }

        return $this->render('paciente/edit.html.twig', array(
            'paciente' => $paciente,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a paciente entity.
     *
     * @Route("/{id}", name="paciente_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Paciente $paciente)
    {
        $form = $this->createDeleteForm($paciente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($paciente);
            $em->flush($paciente);
        }

        return $this->redirectToRoute('paciente_index');
    }

    /**
     * Creates a form to delete a paciente entity.
     *
     * @param Paciente $paciente The paciente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Paciente $paciente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('paciente_delete', array('id' => $paciente->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function procesardatos($datos,$view,$paciente,$create,$edit,$delete){
        foreach($datos as $campo){
            if (!strcmp($this->validar($campo),"OK") == 0){
                $error = $this->validar($campo);
                return $this->renderizar($error,$view,$paciente,$create,$edit,$delete);
            }
        }
        if($create != false){
            if (!strcmp($this->existe($datos['dni']),"OK") == 0){
                $error = $this->existe($datos['dni']);
                return $this->renderizar($error,$view,$paciente,$create,$edit,$delete);
            }
        } else {
            if (!strcmp($this->existeModificar($datos['dni']),"OK") == 0){
                $error = $this->existeModificar($datos['dni']);
                return $this->renderizar($error,$view,$paciente,$create,$edit,$delete);
            }
        }
    }

    private function renderizar($error,$view,$paciente,$create,$edit,$delete){
        if($create != false){
            return $this->render($view, array(
                'error' => $error,
                'paciente' => $paciente,
                'form' => $create,
            ));
        } else {
            return $this->render($view, array(
                'error' => $error,
                'paciente' => $paciente,
                'edit_form' => $edit,
                'delete_form' => $delete,
            ));
        }

    }

    private function validar($texto){
        if (is_array($texto)){
            foreach($texto as $campo){
                return $this->validar($campo);
            }
        }
        if (is_object($texto)){
            return "OK";
        }
        $aux = $texto;
        $aux = strip_tags($aux);
        if (strlen($aux) != strlen($texto)) {
            return "¡Alto! Está intentando ingresar tags.";
        }
        $aux = trim($aux);
        if (strlen($aux) != strlen($texto)) {
            return "¡Alto! Está intentando ingresar caracteres inválidos.";
        }
        if (empty($aux)){
            return "¡Alto! Está intentando ingresar campos vacios.";
        }
        return "OK";
    }

    private function existe($dni){
        $paciente = $this->getDoctrine()->getRepository('AppBundle:Paciente')->findOneBy(array(
            'dni'  => $dni , 'baja' => 0));
        if ($paciente) {
            return "¡Alto! Ya existe un paciente asociado al DNI ingresado.";
        }
        return "OK";
    }

    private function existeModificar($dni){
        if(($_POST['actual'] - $dni) == 0){
            return "OK";
        }
        return $this->existe($dni);
    }
}
