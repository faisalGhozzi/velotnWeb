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
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $cart = $em->getRepository('VelotnBundle:Panier')->findByUser($user);
        $ids=array();
        foreach ($cart as $item)
        {
            array_push($ids,($item->getProduit()->getId()));
        }
        return $this->render('@Velotn/Front/index.html.twig',array(
            'cart'=>$cart
        ));
    }


    /**
     * @Route("/admin",name="admin")
     */
    public function indexBackAction()
    {
        return $this->render('@Velotn/Back/index.html.twig');
    }
}
