<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Personal;
use AppBundle\Form\PersonalType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

/**
 * Personal controller.
 *
 * @Route("/admin")
 */
class PersonalController extends Controller
{
    /**
     * Lists all personal entities.
     *
     * @Route("/",defaults={"page": 1},name="personal_index")
     * @Route("/page/{page}", requirements={"page": "[1-9]\d*"}, name="personal_index_paginated")
     * @Method("GET")
     */
    public function indexAction($page)
    {

        $em = $this->getDoctrine()->getManager();
        //$personals = $em->getRepository('AppBundle:Personal')->findAll();
        $personals = $em->getRepository('AppBundle:Personal')->findLatest($page);
        //$personals = $em->getRepository(Personal::class)->findLatest($page);



        return $this->render('Admin/partials/personal/index.html.twig', array(
            'personals' => $personals,
        ));
    }


    /**
     * Lists all personal entities.
     *
     * @Route("/perfil", name="personal_miperfil")
     * @Method("GET")
     */
    public function miPerfilAction()
    {
        return $this->render('Admin/partials/personal/perfil.html.twig');
    }

    /**
     * Creates a new personal entity.
     *
     * @Route("/new", name="personal_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $personal = new Personal();
        $form = $this->createForm(new PersonalType($this->getDoctrine()), $personal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $formnew = $form->getData();
            $datos = array('nombre' => $formnew->getNombre(), 'apellido' => $formnew->getApellido(), 'genero' => $formnew->getGenero(),
                'DNI' => $formnew->getDni(), 'edad' => $formnew->getEdad(), 'servicios' => $formnew->getServicios(),
                'rol' => $formnew->getRol());


            if($this->procesardatos($datos,'Admin/partials/personal/new.html.twig',$personal,$form->createView(),false,false)){
                return $this->procesardatos($datos,'Admin/partials/personal/new.html.twig',$personal,$form->createView(),false,false);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($personal);
            $em->flush($personal);

            return $this->redirectToRoute('personal_show', array('id' => $personal->getId()));
        }

        return $this->render('Admin/partials/personal/new.html.twig', array(
            'personal' => $personal,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a personal entity.
     *
     * @Route("/{id}", name="personal_show")
     * @Method("GET")
     */
    public function showAction(Personal $personal)
    {
        $deleteForm = $this->createDeleteForm($personal);

        return $this->render('Admin/partials/personal/show.html.twig', array(
            'personal' => $personal,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing personal entity.
     *
     * @Route("/{id}/edit", name="personal_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Personal $personal)
    {
        $deleteForm = $this->createDeleteForm($personal);
        $editForm = $this->createForm('AppBundle\Form\PersonalType', $personal);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $form = $editForm->getData();
            $datos = array('nombre' => $form->getNombre(), 'apellido' => $form->getApellido(), 'genero' => $form->getGenero(),
                'DNI' => $form->getDni(), 'edad' => $form->getEdad(), 'servicios' => $form->getServicios(),
                'rol' => $form->getRol());

            if($this->procesardatos($datos,'Admin/partials/personal/edit.html.twig',$personal,false,$editForm->createView(),$deleteForm->createView())){
                return $this->procesardatos($datos,'Admin/partials/personal/edit.html.twig',$personal,false,$editForm->createView(),$deleteForm->createView());
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('personal_edit', array('id' => $personal->getId()));
        }

        return $this->render('Admin/partials/personal/edit.html.twig', array(
            'personal' => $personal,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a personal entity.
     *
     * @Route("/{id}", name="personal_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Personal $personal)
    {
        $form = $this->createDeleteForm($personal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($personal);
            $em->flush($personal);
        }

        return $this->redirectToRoute('personal_index');
    }

    /**
     * Creates a form to delete a personal entity.
     *
     * @param Personal $personal The personal entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Personal $personal)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('personal_delete', array('id' => $personal->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function procesardatos($datos,$view,$personal,$create,$edit,$delete){
        foreach($datos as $campo){
            if (!strcmp($this->validar($campo),"OK") == 0){
                $error = $this->validar($campo);
                return $this->renderizar($error,$view,$personal,$create,$edit,$delete);
            }
        }
        if (!strcmp($this->existe($datos['DNI']),"OK") == 0){
            $error = $this->existe($datos['DNI']);
            return $this->renderizar($error,$view,$personal,$create,$edit,$delete);
        }
    }

    private function renderizar($error,$view,$personal,$create,$edit,$delete){
        if($create != false){
            return $this->render($view, array(
                'error' => $error,
                'personal' => $personal,
                'form' => $create,
            ));
        } else {
            return $this->render($view, array(
                'error' => $error,
                'personal' => $personal,
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
        $personal = $this->getDoctrine()->getRepository('AppBundle:Personal')->findOneBy(array(
            'dni'  => $dni , 'baja' => 0));
        if ($personal) {
            return "¡Alto! Ya existe un personal asociado al DNI ingresado.";
        }
        return "OK";
    }
}
