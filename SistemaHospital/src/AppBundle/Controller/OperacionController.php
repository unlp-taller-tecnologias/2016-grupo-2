<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Operacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Reserva;
use AppBundle\Entity\Quirofano;
use AppBundle\Entity\Sangre;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;
/**
 * Operacion controller.
 *
 * @Route("/operacion")
 */
class OperacionController extends Controller
{
    /**
     * Lists all operacion entities.
     *
     * @Route("/", name="operacion_index")
     * @Method({"GET","POST"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $opeSinFinalizar = $em->getRepository(Operacion::class)->findNoFinalizada();
        return $this->render('operacion/index.html.twig', array(
            "opeSinFinalizar" =>$opeSinFinalizar,
        ));
    }

    /**
     * Lists all operacion entities.
     *
     * @Route("/incompletas", name="operacion_incompletas")
     * @Method({"GET","POST"})
     */
    public function indexIncompletas()
    {
        $em = $this->getDoctrine()->getManager();

        $incompletas = $em->getRepository(Operacion::class)->findIncompletas();
   

        return $this->render('operacion/incompletas.html.twig', array(
            'incompletas' =>$incompletas,

        ));
    }

    /**
     * Lists all operacion entities.
     *
     * @Route("/search",defaults={"page": 1}, name="operacion_search")
     * @Route("/search/page/{page}", requirements={"page": "[1-9]\d*"}, name="operacion_search_paginated")
     * @Method({"GET","POST"})
     */
    public function  searchAction(Request $request,$page)
    {

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('AppBundle\Form\FiltroOperacionType');
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $datos = $form->getData();
            $page=1;
            if(isset($datos["fechaIni"])){
                $datos["fechaIni"] = str_replace('/', '-', $datos["fechaIni"]);
                $datos["fechaIni"]= date('Y-m-d H:i', strtotime($datos["fechaIni"]));
                if(isset($datos["fechaFin"])){
                    $datos["fechaFin"] = str_replace('/', '-', $datos["fechaFin"]);
                    $datos["fechaFin"]= date('Y-m-d H:i', strtotime( $datos["fechaFin"]));
                }else{
                    $datos["fechaFin"]= 0;
                }
            }
            setcookie("filtrosO",serialize($datos));

            $operaciones = $em->getRepository(Operacion::class)->findLatest($page,$datos);

            return $this->render('operacion/search.html.twig', array(
                'operacions' => $operaciones,
                'form' => $form->createView(),
            ));
        }


        $operaciones=null;

        if(isset($_COOKIE) && isset($_COOKIE["filtrosO"]) ){
            $operaciones = $em->getRepository(Operacion::class)->findLatest($page,unserialize($_COOKIE["filtrosO"]));
        }else{
            $operaciones = $em->getRepository(Operacion::class)->findLatest($page,null);
        }
        return $this->render('operacion/search.html.twig', array(
            'operacions' => $operaciones,
            'form' => $form->createView()
        ));
    }



    /**
     * Creates a new operacion entity.
     *
     * @Route("/new", name="operacion_new")
     * @Method({"GET", "POST"})
     */

    /*
    public function newAction(Request $request)
    {
        $operacion = new Operacion();
        $form = $this->createForm('AppBundle\Form\OperacionType', $operacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($operacion);
            $em->flush($operacion);

            return $this->redirectToRoute('operacion_show', array('id' => $operacion->getId()));
        }

        return $this->render('operacion/new.html.twig', array(
            'operacion' => $operacion,
            'form' => $form->createView(),
        ));
    }
    */

    public function newAction(Request $request)
    {

        $form2 = $this->createForm('AppBundle\Form\NewReservaType');

        $form2->handleRequest($request);


        if ($form2->isSubmitted() && $form2->isValid()){

            $datos = $form2->getData();

            //if($this->procesardatos($datos,'Admin/operacion/new.html.twig',$form2->createView(),false,false)){
            //    return $this->procesardatos($datos,'Admin/operacion/new.html.twig',$form2->createView(),false,false);
            //}

            $operacion = new Operacion();
            $operacion->setDiagnostico($datos["diagnostico"]);
            $operacion->setHabitacion($datos["habitacion"]);
            $operacion->setObservaciones($datos["observaciones"]);
            $operacion->setInternado($datos["Internado"]);
            $operacion->setCirujia($datos["cirugia"]);
            $operacion->setTq($datos["TiempoQuirurgico"]);
            $operacion->setBaja(0); //Se setea en 0 por defecto siempre.
            $operacion->setSangre($datos["sangre"]);
            $operacion->setAsa($datos["asa"]);
            $operacion->setAnestesia($datos["Anestesia"]);


            foreach ($datos["personal"] as $p) {
                $operacion->addPersonal($p);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($operacion);
            $em->flush($operacion);

            $reserva = new Reserva();
            //$reserva->setNumeroReserva($datos['numero_reserva']);
            $reserva->setBaja(0);

             $datos["fecha_inicio"]= date('Y-m-d H:i', strtotime($datos["fecha_inicio"]));

            $datos["fecha_fin"]= date('Y-m-d H:i', strtotime($datos["fecha_fin"]));

            $inicio = new \DateTime($datos['fecha_inicio']);
            $fin = new \DateTime($datos['fecha_fin']);

            $reserva->setFechaInicio($inicio);
            $reserva->setFechaFin($fin);
            $reserva->setPaciente($datos['paciente']);
            $reserva->setServicio($datos['servicio']);
            $reserva->setEstado($datos['estado']);
            $reserva->setQuirofano($datos['quirofano']);
            $reserva->setOperacion($operacion);

            $em->persist($reserva);
            $em->flush($reserva);


            return $this->redirectToRoute('operacion_show', array('id' => $operacion->getId(), 'exito' => 'new'));
        }

        return $this->render('operacion/new.html.twig', array(
            'form2' => $form2->createView()
        ));
    }


    /**
     * Finds and displays a operacion entity.
     *
     * @Route("/{id}/show", name="operacion_show")
     * @Method("GET")
     */
    public function showAction(Operacion $operacion)
    {
        $deleteForm = $this->createDeleteForm($operacion);

        return $this->render('operacion/show.html.twig', array(
            'operacion' => $operacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

     /**
     * Displays a form to edit an existing operacion entity.
     *
     * @Route("/{id}/finish", name="operacion_finish")
     * @Method({"GET", "POST"})
     */
    public function finishAction(Request $request, Operacion $operacion)
    {
        
   
       $em = $this->getDoctrine()->getManager();
       $finalizada = $em->getRepository('AppBundle:Estado')->findOneByTipo('FINALIZADA');
       $operacion->getReserva()->setEstado($finalizada);
       $em->persist($operacion);
       $em->flush($operacion);

       $deleteForm = $this->createDeleteForm($operacion);

        return $this->render('operacion/show.html.twig', array(
            'operacion' => $operacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing operacion entity.
     *
     * @Route("/{id}/edit", name="operacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Operacion $operacion)
    {
        $deleteForm = $this->createDeleteForm($operacion);
        $editForm = $this->createForm('AppBundle\Form\OperacionType', $operacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            //$datos = $editForm->getData();
            //if($this->procesardatos($datos,'Admin/operacion/edit.html.twig',false,$editForm->createView(),$deleteForm->createView())){
            //    return $this->procesardatos($datos,'Admin/operacion/edit.html.twig',false,$editForm->createView(),$deleteForm->createView());
            //}

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('operacion_show', array('id' => $operacion->getId(), 'exito' => 'edit'));

        }

        return $this->render('operacion/edit.html.twig', array(
            'operacion' => $operacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a operacion entity.
     *
     * @Route("/{id}/delete", name="operacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Operacion $operacion)
    {
        $form = $this->createDeleteForm($operacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $operacion->setBaja(1);
            $operacion->getReserva()->setBaja(1);

            $em->persist($operacion->getReserva());
            $em->flush($operacion->getReserva());
            $em->persist($operacion);
            $em->flush($operacion);
        }

        return $this->redirectToRoute('operacion_index');
    }

    /**
     * Creates a form to delete a operacion entity.
     *
     * @param Operacion $operacion The operacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Operacion $operacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('operacion_delete', array('id' => $operacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function procesardatos($datos,$view,$create,$edit,$delete){
        foreach($datos as $campo){
            if (!strcmp($this->validar($campo),"OK") == 0){
                $error = $this->validar($campo);
                return $this->renderizar($error,$view,$create,$edit,$delete);
            }
        }
    }

    private function renderizar($error,$view,$create,$edit,$delete){
        if($create != false){
            return $this->render($view, array(
                'error' => $error,
                'form' => $create,
            ));
        } else {
            return $this->render($view, array(
                'error' => $error,
                'edit_form' => $edit,
                'delete_form' => $delete,
            ));
        }

    }

    private function validar($texto){
        if (is_array($texto)){
            foreach($texto as $campo){
                return $this->validar($campo);
            }
        }
        if (is_object($texto)){
            return "OK";
        }
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
}
