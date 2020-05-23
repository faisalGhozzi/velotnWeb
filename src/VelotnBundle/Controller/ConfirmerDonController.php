<?php

namespace VelotnBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConfirmerDonController extends Controller{

    /**
     * @Route("/cardinfos",name="cardinfos")
     */
    public function confirmerDonAction(){
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $cart = $em->getRepository('VelotnBundle:Panier')->findByUser($user);
        $wish = $em->getRepository('VelotnBundle:Wishlist')->findByUser($user);
        return $this->render('@Velotn/Front/cardinfos.html.twig',array(
            'cart'=>$cart,
            'wish'=>$wish));
    }

}
