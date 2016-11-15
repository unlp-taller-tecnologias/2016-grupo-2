<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sangre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Sangre controller.
 *
 * @Route("Admin/sangre")
 */
class SangreController extends Controller
{
    /**
     * Lists all sangre entities.
     *
     * @Route("/", name="Admin_sangre_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sangres = $em->getRepository('AppBundle:Sangre')->findAll();

        return $this->render('Admin/partials/sangre/index.html.twig', array(
            'sangres' => $sangres,
        ));
    }

    /**
     * Creates a new sangre entity.
     *
     * @Route("/new", name="Admin_sangre_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $sangre = new Sangre();
        $form = $this->createForm('AppBundle\Form\SangreType', $sangre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sangre);
            $em->flush($sangre);

            return $this->redirectToRoute('Admin_sangre_show', array('id' => $sangre->getId()));
        }

        return $this->render('Admin/partials/sangre/new.html.twig', array(
            'sangre' => $sangre,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sangre entity.
     *
     * @Route("/{id}", name="Admin_sangre_show")
     * @Method("GET")
     */
    public function showAction(Sangre $sangre)
    {
        $deleteForm = $this->createDeleteForm($sangre);

        return $this->render('Admin/partials/sangre/show.html.twig', array(
            'sangre' => $sangre,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sangre entity.
     *
     * @Route("/{id}/edit", name="Admin_sangre_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Sangre $sangre)
    {
        $deleteForm = $this->createDeleteForm($sangre);
        $editForm = $this->createForm('AppBundle\Form\SangreType', $sangre);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('Admin_sangre_edit', array('id' => $sangre->getId()));
        }

        return $this->render('Admin/partials/sangre/edit.html.twig', array(
            'sangre' => $sangre,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sangre entity.
     *
     * @Route("/{id}", name="Admin_sangre_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Sangre $sangre)
    {
        $form = $this->createDeleteForm($sangre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sangre);
            $em->flush($sangre);
        }

        return $this->redirectToRoute('Admin_sangre_index');
    }

    /**
     * Creates a form to delete a sangre entity.
     *
     * @param Sangre $sangre The sangre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sangre $sangre)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Admin_sangre_delete', array('id' => $sangre->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
