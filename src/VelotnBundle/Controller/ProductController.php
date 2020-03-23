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
        // REMOVE THIS ! $queryV = $em->createQuery("SELECT v, p FROM VelotnBundle:Velos v JOIN v.id p");


        $all = $em->getRepository('VelotnBundle:Produits')->findAllProducts();
        $velos = $em->getRepository('VelotnBundle:Produits')->findAllVelos();
        $accessoires = $em->getRepository('VelotnBundle:Produits')->findAllAccessoires();
        $piecesrechanges = $em->getRepository('VelotnBundle:Produits')->findAllPieceRechanges();
        $productsLocation = $em->getRepository('VelotnBundle:Produits')->findAllProductsLocation();

        $products = array();
        array_push($products,$velos,$accessoires,$piecesrechanges,$productsLocation);



        return $this->render('@Velotn/Front/shop.html.twig', array(
            'products' => $all
        ));
    }

}
