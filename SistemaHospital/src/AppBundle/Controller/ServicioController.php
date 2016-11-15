<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Servicio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Servicio controller.
 *
 * @Route("admin/servicio")
 */
class ServicioController extends Controller
{
    /**
     * Lists all servicio entities.
     *
     * @Route("/", name="admin_servicio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $servicios = $em->getRepository('AppBundle:Servicio')->findAll();

        return $this->render('Admin/pertials/servicio/index.html.twig', array(
            'servicios' => $servicios,
        ));
    }

    /**
     * Creates a new servicio entity.
     *
     * @Route("/new", name="admin_servicio_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $servicio = new Servicio();
        $form = $this->createForm('AppBundle\Form\ServicioType', $servicio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($servicio);
            $em->flush($servicio);

            return $this->redirectToRoute('admin_servicio_show', array('id' => $servicio->getId()));
        }

        return $this->render('Admin/pertials/servicio/new.html.twig', array(
            'servicio' => $servicio,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a servicio entity.
     *
     * @Route("/{id}", name="admin_servicio_show")
     * @Method("GET")
     */
    public function showAction(Servicio $servicio)
    {
        $deleteForm = $this->createDeleteForm($servicio);

        return $this->render('Admin/pertials/servicio/show.html.twig', array(
            'servicio' => $servicio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing servicio entity.
     *
     * @Route("/{id}/edit", name="admin_servicio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Servicio $servicio)
    {
        $deleteForm = $this->createDeleteForm($servicio);
        $editForm = $this->createForm('AppBundle\Form\ServicioType', $servicio);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_servicio_edit', array('id' => $servicio->getId()));
        }

        return $this->render('Admin/pertials/servicio/edit.html.twig', array(
            'servicio' => $servicio,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a servicio entity.
     *
     * @Route("/{id}", name="admin_servicio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Servicio $servicio)
    {
        $form = $this->createDeleteForm($servicio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($servicio);
            $em->flush($servicio);
        }

        return $this->redirectToRoute('admin_servicio_index');
    }

    /**
     * Creates a form to delete a servicio entity.
     *
     * @param Servicio $servicio The servicio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Servicio $servicio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_servicio_delete', array('id' => $servicio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
