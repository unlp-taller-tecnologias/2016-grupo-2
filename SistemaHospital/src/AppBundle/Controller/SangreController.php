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

            $formnew = $form->getData();
            $datos = array('nombre' => $formnew->getNombre());

            if($this->procesardatos($datos,'Admin/partials/sangre/new.html.twig',$sangre,$form->createView(),false,false)){
                return $this->procesardatos($datos,'Admin/partials/sangre/new.html.twig',$sangre,$form->createView(),false,false);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($sangre);
            $em->flush($sangre);

            return $this->redirectToRoute('Admin_sangre_show', array('id' => $sangre->getId(), 'exito' => 'new'));
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

            $form = $editForm->getData();
            $datos = array('nombre' => $form->getNombre());

            if($this->procesardatos($datos,'Admin/partials/sangre/edit.html.twig',$sangre,false,$editForm->createView(),$deleteForm->createView())){
                return $this->procesardatos($datos,'Admin/partials/sangre/edit.html.twig',$sangre,false,$editForm->createView(),$deleteForm->createView());
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('Admin_sangre_show', array('id' => $sangre->getId(), 'exito' => 'edit'));
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

        return $this->redirectToRoute('Admin_sangre_index', array('exito' => 'delete'));
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

    private function procesardatos($datos,$view,$sangre,$create,$edit,$delete){
        foreach($datos as $campo){
            if (!strcmp($this->validar($campo),"OK") == 0){
                $error = $this->validar($campo);
                return $this->renderizar($error,$view,$sangre,$create,$edit,$delete);
            }
        }
        if($create != false){
            if (!strcmp($this->existe($datos['nombre']),"OK") == 0){
                $error = $this->existe($datos['nombre']);
                return $this->renderizar($error,$view,$sangre,$create,$edit,$delete);
            }
        } else {
            if (!strcmp($this->existeModificar($datos['nombre']),"OK") == 0){
                $error = $this->existeModificar($datos['nombre']);
                return $this->renderizar($error,$view,$sangre,$create,$edit,$delete);
            }
        }
    }

    private function renderizar($error,$view,$sangre,$create,$edit,$delete){
        if($create != false){
            return $this->render($view, array(
                'error' => $error,
                'sangre' => $sangre,
                'form' => $create,
            ));
        } else {
            return $this->render($view, array(
                'error' => $error,
                'sangre' => $sangre,
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
        $sangre = $this->getDoctrine()->getRepository('AppBundle:Sangre')->findOneBy(array(
            'nombre'  => $nombre));
        if ($sangre) {
            return "¡Alto! El nombre de sangre ingresado ya existe.";
        }
        return "OK";
    }

    private function existeModificar($nombre){
        if(isset($_POST['actual'])){
            $actual = $_POST['actual'];
            setcookie('actual',$actual);
        } else {
            $actual = $_COOKIE['actual'];
        }
        if(strcmp($actual,$nombre) == 0){
            return "OK";
        }
        return $this->existe($nombre);
    }
}
