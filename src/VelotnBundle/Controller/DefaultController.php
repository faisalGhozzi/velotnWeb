<?php

namespace VelotnBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('@Velotn/Back/index.html.twig');
    }

    /**
     * @Route("/login")
     */
    public function loginAction()
    {
        return $this->render('@Velotn/Back/login.html.twig');
    }

    /**
     * @Route("/loginfront")
     */
    public function loginFrontAction()
    {
        return $this->render('@Velotn/Front/login.html.twig');
    }

    /**
     * @Route("/front")
     */
    public function indexFrontAction()
    {
        return $this->render('@Velotn/Front/index.html.twig');
    }
}
