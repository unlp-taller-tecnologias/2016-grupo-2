<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Anestesia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Anestesium controller.
 *
 * @Route("admin/anestesia")
 */
class AnestesiaController extends Controller
{
    /**
     * Lists all anestesium entities.
     *
     * @Route("/", name="admin_anestesia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $anestesias = $em->getRepository('AppBundle:Anestesia')->findAll();

        return $this->render('Admin/partials/anestesia/index.html.twig', array(
            'anestesias' => $anestesias,
        ));
    }

    /**
     * Creates a new anestesium entity.
     *
     * @Route("/new", name="admin_anestesia_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $anestesium = new Anestesia();
        $form = $this->createForm('AppBundle\Form\AnestesiaType', $anestesium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($anestesium);
            $em->flush($anestesium);

            return $this->redirectToRoute('admin_anestesia_show', array('id' => $anestesium->getId()));
        }

        return $this->render('Admin/partials/anestesia/new.html.twig', array(
            'anestesium' => $anestesium,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a anestesium entity.
     *
     * @Route("/{id}", name="admin_anestesia_show")
     * @Method("GET")
     */
    public function showAction(Anestesia $anestesium)
    {
        $deleteForm = $this->createDeleteForm($anestesium);

        return $this->render('Admin/partials/anestesia/show.html.twig', array(
            'anestesium' => $anestesium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing anestesium entity.
     *
     * @Route("/{id}/edit", name="admin_anestesia_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Anestesia $anestesium)
    {
        $deleteForm = $this->createDeleteForm($anestesium);
        $editForm = $this->createForm('AppBundle\Form\AnestesiaType', $anestesium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_anestesia_edit', array('id' => $anestesium->getId()));
        }

        return $this->render('Admin/partials/anestesia/edit.html.twig', array(
            'anestesium' => $anestesium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a anestesium entity.
     *
     * @Route("/{id}", name="admin_anestesia_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Anestesia $anestesium)
    {
        $form = $this->createDeleteForm($anestesium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($anestesium);
            $em->flush($anestesium);
        }

        return $this->redirectToRoute('admin_anestesia_index');
    }

    /**
     * Creates a form to delete a anestesium entity.
     *
     * @param Anestesia $anestesium The anestesium entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Anestesia $anestesium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_anestesia_delete', array('id' => $anestesium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
