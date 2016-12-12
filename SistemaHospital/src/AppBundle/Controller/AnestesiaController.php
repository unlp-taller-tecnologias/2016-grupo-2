<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Anestesia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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

            $formnew = $form->getData();
            $datos = array('tipo' => $formnew->getTipo(), 'descripcion' => $formnew->getDescripcion());

            if($this->procesardatos($datos,'Admin/partials/anestesia/new.html.twig',$anestesium,$form->createView(),false,false)){
                return $this->procesardatos($datos,'Admin/partials/anestesia/new.html.twig',$anestesium,$form->createView(),false,false);
            }

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

            $form = $editForm->getData();
            $datos = array('tipo' => $form->getTipo(), 'descripcion' => $form->getDescripcion());

            if($this->procesardatos($datos,'Admin/partials/anestesia/edit.html.twig',$anestesium,false,$editForm->createView(),$deleteForm->createView())){
                return $this->procesardatos($datos,'Admin/partials/anestesia/edit.html.twig',$anestesium,false,$editForm->createView(),$deleteForm->createView());
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_anestesia_show', array('id' => $anestesium->getId()));
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

    private function procesardatos($datos,$view,$anestesia,$create,$edit,$delete){
        foreach($datos as $campo){
            if (!strcmp($this->validar($campo),"OK") == 0){
                $error = $this->validar($campo);
                return $this->renderizar($error,$view,$anestesia,$create,$edit,$delete);
            }
        }
        if (!strcmp($this->existe($datos['tipo']),"OK") == 0){
            $error = $this->existe($datos['tipo']);
            return $this->renderizar($error,$view,$anestesia,$create,$edit,$delete);
        }
    }

    private function renderizar($error,$view,$anestesia,$create,$edit,$delete){
        if($create != false){
            return $this->render($view, array(
                'error' => $error,
                'anestesium' => $anestesia,
                'form' => $create,
            ));
        } else {
            return $this->render($view, array(
                'error' => $error,
                'anestesium' => $anestesia,
                'edit_form' => $edit,
                'delete_form' => $delete,
            ));
        }

    }

    private function validar($texto){
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

    private function existe($tipo){
        $anestesia = $this->getDoctrine()->getRepository('AppBundle:Anestesia')->findOneBy(array(
            'tipo'  => $tipo , 'baja' => 0));
        if ($anestesia) {
            return "¡Alto! El tipo de anestesia ingresado ya existe.";
        }
        return "OK";
    }
}
