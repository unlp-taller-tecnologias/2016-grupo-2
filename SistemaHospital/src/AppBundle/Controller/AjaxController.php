<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Anestesia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use SSP;

/**
 * Ajax controller.
 *
 * @Route("/ajax")
 */
class AjaxController extends Controller
{

    /**     *
     * @Route("/ejemplo" , name="ajax_ejemplo")
     * @Method("POST")
     */
    public function ajaxsimple(Request $request){
        return new Response("alalalalalalla");

    }


}