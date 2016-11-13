<?php
/**
 * Created by PhpStorm.
 * User: Fer
 * Date: 11/11/2016
 * Time: 18:02
 */

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class AdminController extends  Controller
{
    /**
     * @Route("/", name="admin_index")
     */
    public function listaPersonalAction()
    {
        // replace this example code with whatever you need
        //return $this->render('default/index.html.twig');
        return $this->render('Admin/partials/listaPersonal.html.twig'/*, ['reservas' => $reservas]*/);
    }

    public function listaUserAction()
    {
        // replace this example code with whatever you need
        //return $this->render('default/index.html.twig');
        return $this->render('Admin/partials/listaUser.html.twig'/*, ['reservas' => $reservas]*/);
    }
}