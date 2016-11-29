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
}
