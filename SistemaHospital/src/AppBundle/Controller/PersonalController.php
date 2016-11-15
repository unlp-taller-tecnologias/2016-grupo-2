<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Personal;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Personal controller.
 *
 * @Route("personal")
 */
class PersonalController extends Controller
{
    /**
     * Lists all personal entities.
     *
     * @Route("/", name="personal_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $personals = $em->getRepository('AppBundle:Personal')->findAll();

        return $this->render('personal/index.html.twig', array(
            'personals' => $personals,
        ));
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
        $form = $this->createForm('AppBundle\Form\PersonalType', $personal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($personal);
            $em->flush($personal);

            return $this->redirectToRoute('personal_show', array('id' => $personal->getId()));
        }

        return $this->render('personal/new.html.twig', array(
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

        return $this->render('personal/show.html.twig', array(
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

        return $this->render('personal/edit.html.twig', array(
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
