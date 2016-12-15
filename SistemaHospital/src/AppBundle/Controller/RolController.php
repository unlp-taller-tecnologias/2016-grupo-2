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
            $formnew = $form->getData();
            $datos = array('nombre' => $formnew->getNombre());

            if($this->procesardatos($datos,'Admin/partials/rol/new.html.twig',$rol,$form->createView(),false,false)){
                return $this->procesardatos($datos,'Admin/partials/rol/new.html.twig',$rol,$form->createView(),false,false);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($rol);
            $em->flush($rol);

            return $this->redirectToRoute('admin_rol_show', array('id' => $rol->getId(), 'exito' => 'new'));
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

            $form = $editForm->getData();
            $datos = array('nombre' => $form->getNombre());

            if($this->procesardatos($datos,'Admin/partials/rol/edit.html.twig',$rol,false,$editForm->createView(),$deleteForm->createView())){
                return $this->procesardatos($datos,'Admin/partials/rol/edit.html.twig',$rol,false,$editForm->createView(),$deleteForm->createView());
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_rol_show', array('id' => $rol->getId(), 'exito' => 'edit'));
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
            $rol->setBaja(1);
            $em->persist($rol);
            $em->flush($rol);
        }

        return $this->redirectToRoute('admin_rol_index', array('exito' => 'delete'));
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

    private function procesardatos($datos,$view,$rol,$create,$edit,$delete){
        foreach($datos as $campo){
            if (!strcmp($this->validar($campo),"OK") == 0){
                $error = $this->validar($campo);
                return $this->renderizar($error,$view,$rol,$create,$edit,$delete);
            }
        }
        if($create != false){
            if (!strcmp($this->existe($datos['nombre']),"OK") == 0){
                $error = $this->existe($datos['nombre']);
                return $this->renderizar($error,$view,$rol,$create,$edit,$delete);
            }
        } else {
            if (!strcmp($this->existeModificar($datos['nombre']),"OK") == 0){
                $error = $this->existeModificar($datos['nombre']);
                return $this->renderizar($error,$view,$rol,$create,$edit,$delete);
            }
        }
    }

    private function renderizar($error,$view,$rol,$create,$edit,$delete){
        if($create != false){
            return $this->render($view, array(
                'error' => $error,
                'rol' => $rol,
                'form' => $create,
            ));
        } else {
            return $this->render($view, array(
                'error' => $error,
                'rol' => $rol,
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
        $rol = $this->getDoctrine()->getRepository('AppBundle:Rol')->findOneBy(array(
            'nombre'  => $nombre , 'baja' => 0));
        if ($rol) {
            return "¡Alto! El nombre de rol ingresado ya existe.";
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
