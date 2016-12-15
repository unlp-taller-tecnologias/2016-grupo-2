<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("/admin/user")
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('Admin/partials/user/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new user entity.
     *
     * @Route("{id_personal}/new", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $id_personal)
    {

        $user = new User();
        $form = $this->createForm(new UserType($this->getDoctrine()),$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->addRole("ROLE_ADMIN");
            $user->setEnabled(true);

            $em = $this->getDoctrine()->getManager();

            $personal= $em->getRepository('AppBundle:Personal')->find($id_personal);
            $user->setPersonal($personal);

            $formnew = $form->getData();
            $datos = array('username' => $formnew->getUsername(), 'mail' => $formnew->getEmail(), 'pass1' => $formnew->getPlainPassword('first'),
                'pass2' => $formnew->getPlainPassword('second'));

            if($this->procesardatos($datos,'Admin/partials/user/new.html.twig',$user,$form->createView(),false,false)){
                return $this->procesardatos($datos,'Admin/partials/user/new.html.twig',$user,$form->createView(),false,false);
            }

            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user_show', array('id' => $user->getId(), 'exito' => 'new'));
        }

        return $this->render('Admin/partials/user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('Admin/partials/user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm(new UserType($this->getDoctrine()), $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $form = $editForm->getData();
            $datos = array('username' => $form->getUsername(), 'mail' => $form->getEmail(), 'pass1' => $form->getPlainPassword('first'),
                'pass2' => $form->getPlainPassword('second'));

            if($this->procesardatos($datos,'Admin/partials/user/edit.html.twig',$user,false,$editForm->createView(),$deleteForm->createView())){
                return $this->procesardatos($datos,'Admin/partials/user/edit.html.twig',$user,false,$editForm->createView(),$deleteForm->createView());
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_show', array('id' => $user->getId(), 'exito' => 'edit'));
        }

        return $this->render('Admin/partials/user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setBaja(1);
            $em->persist($user);
            $em->flush($user);
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function procesardatos($datos,$view,$usuario,$create,$edit,$delete){
        foreach($datos as $campo){
            if (!strcmp($this->validar($campo),"OK") == 0){
                $error = $this->validar($campo);
                return $this->renderizar($error,$view,$usuario,$create,$edit,$delete);
            }
        }
        if($create != false){
            if (!strcmp($this->existe($datos['username']),"OK") == 0){
                $error = $this->existe($datos['username']);
                return $this->renderizar($error,$view,$usuario,$create,$edit,$delete);
            }
            if (!strcmp($this->existeMail($datos['mail']),"OK") == 0){
                $error = $this->existeMail($datos['mail']);
                return $this->renderizar($error,$view,$usuario,$create,$edit,$delete);
            }
        } else {
            if (!strcmp($this->existeModificar($datos['username']),"OK") == 0){
                $error = $this->existeModificar($datos['username']);
                return $this->renderizar($error,$view,$usuario,$create,$edit,$delete);
            }
            if (!strcmp($this->existeMailModificar($datos['mail']),"OK") == 0){
                $error = $this->existeMailModificar($datos['mail']);
                return $this->renderizar($error,$view,$usuario,$create,$edit,$delete);
            }
        }
        if (!strcmp($this->validarMail($datos['mail']),"OK") == 0){
            $error = $this->validarMail($datos['mail']);
            return $this->renderizar($error,$view,$usuario,$create,$edit,$delete);
        }
    }

    private function renderizar($error,$view,$usuario,$create,$edit,$delete){
        if($create != false){
            return $this->render($view, array(
                'error' => $error,
                'user' => $usuario,
                'form' => $create,
            ));
        } else {
            return $this->render($view, array(
                'error' => $error,
                'user' => $usuario,
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

    private function existe($usuario){
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array(
            'username'  => $usuario , 'enabled' => 1));
        if ($user) {
            return "¡Alto! El nombre de usuario ingresado ya existe.";
        }
        return "OK";
    }

    private function existeMail($mail){
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array(
            'email'  => $mail , 'enabled' => 1));
        if ($user) {
            return "¡Alto! El E-Mail ingresado ya se encuentra asociado a un usuario existente.";
        }
        return "OK";
    }

    private function existeModificar($username){
        if(strcmp($_POST['actual'],$username) == 0){
            return "OK";
        }
        return $this->existe($username);
    }

    private function existeMailModificar($mail){
        if(strcmp($_POST['mailactual'],$mail) == 0){
            return "OK";
        }
        return $this->existeMail($mail);
    }

    private function validarMail($mail){
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            return "¡Alto! El formato del mail es incorrecto.";
        }
        return "OK";
    }
}

