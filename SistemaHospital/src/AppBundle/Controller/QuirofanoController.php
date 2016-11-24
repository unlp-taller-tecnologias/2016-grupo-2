<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Quirofano;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Quirofano controller.
 *
 * @Route("admin/quirofano")
 */
class QuirofanoController extends Controller
{
    /**
     * Lists all quirofano entities.
     *
     * @Route("/", name="admin_quirofano_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $quirofanos = $em->getRepository('AppBundle:Quirofano')->findAll();

        return $this->render('Admin/partials/quirofano/index.html.twig', array(
            'quirofanos' => $quirofanos,
        ));
    }

    /**
     * Creates a new quirofano entity.
     *
     * @Route("/new", name="admin_quirofano_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $quirofano = new Quirofano();
        $form = $this->createForm('AppBundle\Form\QuirofanoType', $quirofano);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($quirofano);
            $em->flush($quirofano);

            return $this->redirectToRoute('admin_quirofano_show', array('id' => $quirofano->getId()));
        }

        return $this->render('Admin/partials/quirofano/new.html.twig', array(
            'quirofano' => $quirofano,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a quirofano entity.
     *
     * @Route("/{id}", name="admin_quirofano_show")
     * @Method("GET")
     */
    public function showAction(Quirofano $quirofano)
    {
        $deleteForm = $this->createDeleteForm($quirofano);

        return $this->render('Admin/partials/quirofano/show.html.twig', array(
            'quirofano' => $quirofano,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing quirofano entity.
     *
     * @Route("/{id}/edit", name="admin_quirofano_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Quirofano $quirofano)
    {
        $deleteForm = $this->createDeleteForm($quirofano);
        $editForm = $this->createForm('AppBundle\Form\QuirofanoType', $quirofano);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_quirofano_edit', array('id' => $quirofano->getId()));
        }

        return $this->render('Admin/partials/quirofano/edit.html.twig', array(
            'quirofano' => $quirofano,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a quirofano entity.
     *
     * @Route("/{id}", name="admin_quirofano_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Quirofano $quirofano)
    {
        $form = $this->createDeleteForm($quirofano);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($quirofano);
            $em->flush($quirofano);
        }

        return $this->redirectToRoute('admin_quirofano_index');
    }


    /**
     * Creates a form to delete a quirofano entity.
     *
     * @param Quirofano $quirofano The quirofano entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Quirofano $quirofano)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_quirofano_delete', array('id' => $quirofano->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


}
