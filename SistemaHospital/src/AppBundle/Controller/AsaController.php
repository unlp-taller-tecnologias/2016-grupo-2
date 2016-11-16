<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Asa;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Asa controller.
 *
 * @Route("admin/asa")
 */
class AsaController extends Controller
{
    /**
     * Lists all asa entities.
     *
     * @Route("/", name="admin_asa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $asas = $em->getRepository('AppBundle:Asa')->findAll();

        return $this->render('Admin/partials/asa/index.html.twig', array(
            'asas' => $asas,
        ));
    }

    /**
     * Creates a new asa entity.
     *
     * @Route("/new", name="admin_asa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $asa = new Asa();
        $form = $this->createForm('AppBundle\Form\AsaType', $asa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($asa);
            $em->flush($asa);

            return $this->redirectToRoute('admin_asa_show', array('id' => $asa->getId()));
        }

        return $this->render('Admin/partials/asa/new.html.twig', array(
            'asa' => $asa,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a asa entity.
     *
     * @Route("/{id}", name="admin_asa_show")
     * @Method("GET")
     */
    public function showAction(Asa $asa)
    {
        $deleteForm = $this->createDeleteForm($asa);

        return $this->render('Admin/partials/asa/show.html.twig', array(
            'asa' => $asa,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing asa entity.
     *
     * @Route("/{id}/edit", name="admin_asa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Asa $asa)
    {
        $deleteForm = $this->createDeleteForm($asa);
        $editForm = $this->createForm('AppBundle\Form\AsaType', $asa);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_asa_edit', array('id' => $asa->getId()));
        }

        return $this->render('Admin/partials/asa/edit.html.twig', array(
            'asa' => $asa,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a asa entity.
     *
     * @Route("/{id}", name="admin_asa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Asa $asa)
    {
        $form = $this->createDeleteForm($asa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($asa);
            $em->flush($asa);
        }

        return $this->redirectToRoute('admin_asa_index');
    }

    /**
     * Creates a form to delete a asa entity.
     *
     * @param Asa $asa The asa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Asa $asa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_asa_delete', array('id' => $asa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
