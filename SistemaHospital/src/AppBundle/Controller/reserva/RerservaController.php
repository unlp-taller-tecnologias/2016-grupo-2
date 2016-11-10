<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller\reserva;

use AppBundle\Entity\Reserva;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use AppBundle\Form\CommentType;

/**
 * Controller used to manage blog contents in the public part of the site.
 *
 * @Route("/reserva")
 */
class RerservaController extends Controller
{
    /**
     * @Route("/", defaults={"page": 1}, name="reserva_index")
     * @Route("/page/{page}", requirements={"page": "[1-9]\d*"}, name="reserva_index_paginated")
     * @Method("GET")
     * @Cache(smaxage="10")
     */
    public function indexAction($page)
    {
        //por lo pronto esto no se va a esjecutar pero sirve como para paginar las reservas...
        //$reservas = $this->getDoctrine()->getRepository(Reserva::class)->findLatest($page);

        return $this->render('reservas/index.html.twig'/*, ['reservas' => $reservas]*/);
    }

}
