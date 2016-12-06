<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Operacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            if(isset($datos["fechaIni"]) &&  isset($datos["fechaFin"])){
                $datos["fechaIni"] = str_replace('/', '-', $datos["fechaIni"]);
                $datos["fechaIni"]= date('Y-m-d H:i', strtotime($datos["fechaIni"]));

                $datos["fechaFin"] = str_replace('/', '-', $datos["fechaFin"]);
                $datos["fechaFin"]= date('Y-m-d H:i', strtotime( $datos["fechaFin"]));
            }
            $operaciones = $em->getRepository(Operacion::class)->findLatest($page,$datos);

            return $this->render('operacion/search.html.twig', array(
                'operacions' => $operaciones,
                'form' => $form->createView(),
            ));
        }
        $operaciones = $em->getRepository(Operacion::class)->findLatest($page,null);
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
     * @Route("/{id}/edit", name="operacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Operacion $operacion)
    {
        $deleteForm = $this->createDeleteForm($operacion);
        $editForm = $this->createForm('AppBundle\Form\OperacionType', $operacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('operacion_edit', array('id' => $operacion->getId()));
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
            $em->remove($operacion);
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
}
