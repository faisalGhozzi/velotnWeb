<?php

namespace VelotnBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/admin",name="admin")
     */
    public function indexAction()
    {
        return $this->render('@Velotn/Back/index.html.twig');
    }

    /**
     * @Route("/loginadmin",name="loginadmin")
     */
    public function loginAction()
    {
        return $this->render('@Velotn/Back/login.html.twig');
    }

    /**
     * @Route("/login",name="login")
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

    /**
     * @Route("/contact",name="contact")
     */

    public function contactAction(){
        return $this->render('@Velotn/Front/contact.html.twig');
    }

    /**
     * @Route("/cart",name="cart")
     */

    public function shoppingcartAction(){
        return $this->render('@Velotn/Front/shopping-cart.html.twig');
    }

    /**
     * @Route("/checkout",name="checkout")
     */

    public function checkoutAction(){
        return $this->render('@Velotn/Front/checkout.html.twig');
    }

    /**
     * @Route("/event/oh",name="eventinfo")
     */

    public function eventinfoAction(){
        return $this->render('@Velotn/Front/event-details.html.twig');
    }
}
