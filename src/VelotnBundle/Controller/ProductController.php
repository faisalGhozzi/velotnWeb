<?php

namespace VelotnBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProductController extends Controller
{
    /**
     * @Route("/shop",name="shop")
     */
    public function showAction()
    {
        $products = $this->getDoctrine()->getRepository('VelotnBundle:Produits')->findAll();
        dump($products);
        return $this->render('@Velotn/Front/shop.html.twig', array(
            'products' => $products
        ));
    }

}
