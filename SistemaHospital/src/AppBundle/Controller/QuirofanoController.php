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

            $formnew = $form->getData();
            $datos = array('nombre' => $formnew->getNombre());

            if($this->procesardatos($datos,'Admin/partials/quirofano/new.html.twig',$quirofano,$form->createView(),false,false)){
                return $this->procesardatos($datos,'Admin/partials/quirofano/new.html.twig',$quirofano,$form->createView(),false,false);
            }

            $em = $this->getDoctrine()->getManager();

            if($aux = $this->existeElemntoEnBaja($quirofano->getNombre())){
                /*recorro todos los campos de asa para aplicarselos a aux*/
                $aux->setBaja(0);
                $aux->setNombre($quirofano->getNombre());
                /****************/
                $em->persist($aux);
                $em->flush();
                return $this->redirectToRoute('admin_quirofano_show', array('id' => $aux->getId(), 'exito' => 'new'));
            }else{
                $em->persist($quirofano);
                $em->flush();
            }
            return $this->redirectToRoute('admin_quirofano_show', array('id' => $quirofano->getId(), 'exito' => 'new'));
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

            $form = $editForm->getData();
            $datos = array('nombre' => $form->getNombre());

            if($this->procesardatos($datos,'Admin/partials/quirofano/edit.html.twig',$quirofano,false,$editForm->createView(),$deleteForm->createView())){
                return $this->procesardatos($datos,'Admin/partials/quirofano/edit.html.twig',$quirofano,false,$editForm->createView(),$deleteForm->createView());
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_quirofano_show', array('id' => $quirofano->getId(), 'exito' => 'edit'));
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
            $quirofano->setBaja(1);
            $em->persist($quirofano);
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

    private function procesardatos($datos,$view,$quirofano,$create,$edit,$delete){
        foreach($datos as $campo){
            if (!strcmp($this->validar($campo),"OK") == 0){
                $error = $this->validar($campo);
                return $this->renderizar($error,$view,$quirofano,$create,$edit,$delete);
            }
        }
        if($create != false){
            if (!strcmp($this->existe($datos['nombre']),"OK") == 0){
                $error = $this->existe($datos['nombre']);
                return $this->renderizar($error,$view,$quirofano,$create,$edit,$delete);
            }
        } else {
            if (!strcmp($this->existeModificar($datos['nombre']),"OK") == 0){
                $error = $this->existeModificar($datos['nombre']);
                return $this->renderizar($error,$view,$quirofano,$create,$edit,$delete);
            }
        }
    }

    private function renderizar($error,$view,$quirofano,$create,$edit,$delete){
        if($create != false){
            return $this->render($view, array(
                'error' => $error,
                'quirofano' => $quirofano,
                'form' => $create,
            ));
        } else {
            return $this->render($view, array(
                'error' => $error,
                'quirofano' => $quirofano,
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

    private function existe($nombre){
        $quirofano = $this->getDoctrine()->getRepository('AppBundle:Quirofano')->findOneBy(array(
            'nombre'  => $nombre, 'baja' => 0));
        if ($quirofano) {
            return "¡Alto! El nombre de quirófano ingresado ya existe.";
        }
        return "OK";
    }

    private function existeElemntoEnBaja($nombre){
        $aux = $this->getDoctrine()->getRepository('AppBundle:Quirofano')->findOneBy(array(
            'nombre'  => $nombre , 'baja' => 1));
        if ($aux) {
            return $aux;
        }
        return false;
    }


    private function existeModificar($nombre){
        if(strcmp($_POST['actual'],$nombre) == 0){
            return "OK";
        }
        return $this->existe($nombre);
    }


}
