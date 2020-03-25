<?php

namespace VelotnBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('@Velotn/Back/index.html.twig');
    }


    /**
     * @return Response
     * @Route("/admin/login",name="adminlogin")
     */
    public function loginAction()
    {
        return $this->render('@Velotn/Back/login.html.twig');
    }

    /**
     * @return Response
     * @Route("/login",name="login")
     */
    public function loginFrontAction()
    {
        return $this->render('@Velotn/Front/login.html.twig');
    }

    /**
     * @Route("/",name="index")
     */
    public function indexFrontAction()
    {
        return $this->render('@Velotn/Front/index.html.twig');
    }


    /**
     * @Route("/admin",name="admin")
     */
    public function indexBackAction()
    {
        return $this->render('@Velotn/Back/index.html.twig');
    }

    /*public function shopAction(){
        return $this->render('@Velotn/Front/shop.html.twig');
    }*/



    public function eventsAction(){
        return $this->render('@Velotn/Front/events.html.twig');
    }


    public function contactAction(){
        return $this->render('@Velotn/Front/contact.html.twig');
    }


    public function shoppingcartAction(){
        return $this->render('@Velotn/Front/shopping-cart.html.twig');
    }



    public function checkoutAction(){
        return $this->render('@Velotn/Front/checkout.html.twig');
    }


    public function eventinfoAction(){
        return $this->render('@Velotn/Front/event-details.html.twig');
    }
}
