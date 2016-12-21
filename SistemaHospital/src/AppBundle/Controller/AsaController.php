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

            $formnew = $form->getData();
            $datos = array('grado' => $formnew->getGrado(), 'descripcion' => $formnew->getDescripcion());

            if($this->procesardatos($datos,'Admin/partials/asa/new.html.twig',$asa,$form->createView(),false,false)){
                return $this->procesardatos($datos,'Admin/partials/asa/new.html.twig',$asa,$form->createView(),false,false);
            }

            $em = $this->getDoctrine()->getManager();

            if($aux = $this->existeElemntoEnBaja($asa->getGrado())){
                /*recorro todos los campos de asa para aplicarselos a aux*/
                $aux->setBaja(0);
                $aux->setDescripcion($asa->getDescripcion());
                $aux->setGrado($asa->getGrado());
                /****************/
                $em->persist($aux);
                $em->flush();
                return $this->redirectToRoute('admin_asa_show', array('id' => $aux->getId(), 'exito' => 'new'));
            }else{
                $em->persist($asa);
                $em->flush();
            }
            return $this->redirectToRoute('admin_asa_show', array('id' => $asa->getId(), 'exito' => 'new'));
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
     * @Method("GET")Asa
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

            $form = $editForm->getData();
            $datos = array('grado' => $form->getGrado(), 'descripcion' => $form->getDescripcion());

            if($this->procesardatos($datos,'Admin/partials/asa/edit.html.twig',$asa,false,$editForm->createView(),$deleteForm->createView())){
                return $this->procesardatos($datos,'Admin/partials/asa/edit.html.twig',$asa,false,$editForm->createView(),$deleteForm->createView());
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_asa_show', array('id' => $asa->getId(), 'exito' => 'edit'));
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
            $asa->setBaja(1);
            $em->persist($asa);
            $em->flush($asa);
        }

        return $this->redirectToRoute('admin_asa_index', array('exito' => 'delete'));
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

    private function procesardatos($datos,$view,$asa,$create,$edit,$delete){
        foreach($datos as $campo){
            if (!strcmp($this->validar($campo),"OK") == 0){
                $error = $this->validar($campo);
                return $this->renderizar($error,$view,$asa,$create,$edit,$delete);
            }
        }
        if($create != false){
            if (!strcmp($this->existe($datos['grado']),"OK") == 0){
                $error = $this->existe($datos['grado']);
                return $this->renderizar($error,$view,$asa,$create,$edit,$delete);
            }
        } else {
            if (!strcmp($this->existeModificar($datos['grado']),"OK") == 0){
                $error = $this->existeModificar($datos['grado']);
                return $this->renderizar($error,$view,$asa,$create,$edit,$delete);
            }
        }
    }

    private function renderizar($error,$view,$asa,$create,$edit,$delete){
        if($create != false){
            return $this->render($view, array(
                'error' => $error,
                'asa' => $asa,
                'form' => $create,
            ));
        } else {
            return $this->render($view, array(
                'error' => $error,
                'asa' => $asa,
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

    private function existe($grado){
        $asa = $this->getDoctrine()->getRepository('AppBundle:Asa')->findOneBy(array(
            'grado'  => $grado , 'baja' => 0));
        if ($asa) {
            return "¡Alto! El nombre de ASA ingresado ya existe.";
        }
        return "OK";
    }

    private function existeElemntoEnBaja($grado){
        $aux = $this->getDoctrine()->getRepository('AppBundle:Asa')->findOneBy(array(
            'grado'  => $grado , 'baja' => 1));
        if ($aux) {
            return $aux;
        }
        return false;
    }

    private function existeModificar($grado){
        if(isset($_POST['actual'])){
            $actual = $_POST['actual'];
            setcookie('actual',$actual);
        } else {
            $actual = $_COOKIE['actual'];
        }
        if(strcmp($actual,$grado) == 0){
            return "OK";
        }
        return $this->existe($grado);
    }
}
