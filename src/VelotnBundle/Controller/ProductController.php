<?php

namespace VelotnBundle\Controller;

use Doctrine\ORM\Query\Expr\Select;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use VelotnBundle\Entity\ProduitsLocation;
use VelotnBundle\Entity\Velos;

class ProductController extends Controller
{
    /**
     * @Route("/shop",name="shop")
     */
    public function showAction()
    {
        /*$velos = $this->getDoctrine()->getRepository('VelotnBundle:Velos')->findAll();
        $pieces = $this->getDoctrine()->getRepository('VelotnBundle:Piecesrechanges')->findAll();
        $accessoires = $this->getDoctrine()->getRepository('VelotnBundle:Accessoires')->findAll();
        $products = array();
        array_push($products,$velos,$pieces,$accessoires);
        dump($products);*/
        $em = $this->getDoctrine()->getManager();
        $queryV = $em->createQuery("SELECT v, p FROM VelotnBundle:Velos v JOIN v.id p");
        $res = $queryV->getResult();
        dump($res);

        return $this->render('@Velotn/Front/shop.html.twig', array(
            'products' => $res
        ));
    }

}
