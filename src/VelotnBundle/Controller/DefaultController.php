<?php

namespace VelotnBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/admin")
     */
    public function indexAction()
    {
        return $this->render('@Velotn/Back/index.html.twig');
    }

    /**
     * @Route("/loginadmin")
     */
    public function loginAction()
    {
        return $this->render('@Velotn/Back/login.html.twig');
    }

    /**
     * @Route("/login")
     */
    public function loginFrontAction()
    {
        return $this->render('@Velotn/Front/login.html.twig');
    }

    /**
     * @Route("/",name="home")
     */
    public function indexFrontAction()
    {
        return $this->render('@Velotn/Front/index.html.twig');
    }

    /**
     * @Route("/shop",name="shop")
     */

    public function shopAction(){
        return $this->render('@Velotn/Front/shop.html.twig');
    }

    /**
     * @Route("/events",name="events")
     */

    public function eventsAction(){
        return $this->render('@Velotn/Front/events.html.twig');
    }
}
