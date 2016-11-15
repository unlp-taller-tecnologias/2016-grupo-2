<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Rol;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Rol controller.
 *
 * @Route("admin/rol")
 */
class RolController extends Controller
{
    /**
     * Lists all rol entities.
     *
     * @Route("/", name="admin_rol_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $rols = $em->getRepository('AppBundle:Rol')->findAll();

        return $this->render('Admin/partials/rol/index.html.twig', array(
            'rols' => $rols,
        ));
    }

    /**
     * Creates a new rol entity.
     *
     * @Route("/new", name="admin_rol_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $rol = new Rol();
        $form = $this->createForm('AppBundle\Form\RolType', $rol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rol);
            $em->flush($rol);

            return $this->redirectToRoute('admin_rol_show', array('id' => $rol->getId()));
        }

        return $this->render('Admin/partials/rol/new.html.twig', array(
            'rol' => $rol,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a rol entity.
     *
     * @Route("/{id}", name="admin_rol_show")
     * @Method("GET")
     */
    public function showAction(Rol $rol)
    {
        $deleteForm = $this->createDeleteForm($rol);

        return $this->render('Admin/partials/rol/show.html.twig', array(
            'rol' => $rol,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing rol entity.
     *
     * @Route("/{id}/edit", name="admin_rol_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Rol $rol)
    {
        $deleteForm = $this->createDeleteForm($rol);
        $editForm = $this->createForm('AppBundle\Form\RolType', $rol);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_rol_edit', array('id' => $rol->getId()));
        }

        return $this->render('Admin/partials/rol/edit.html.twig', array(
            'rol' => $rol,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a rol entity.
     *
     * @Route("/{id}", name="admin_rol_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Rol $rol)
    {
        $form = $this->createDeleteForm($rol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rol);
            $em->flush($rol);
        }

        return $this->redirectToRoute('admin_rol_index');
    }

    /**
     * Creates a form to delete a rol entity.
     *
     * @param Rol $rol The rol entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Rol $rol)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_rol_delete', array('id' => $rol->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
