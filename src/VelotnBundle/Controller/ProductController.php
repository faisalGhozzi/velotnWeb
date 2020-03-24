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
        $em = $this->getDoctrine()->getManager();
        // REMOVE THIS ! $queryV = $em->createQuery("SELECT v, p FROM VelotnBundle:Velos v JOIN v.id p");


        $all = $em->getRepository('VelotnBundle:Produits')->findAllProducts();
        $velos = $em->getRepository('VelotnBundle:Velos')->findAllVelos();
        $accessoires = $em->getRepository('VelotnBundle:Accessoires')->findAllAccessoires();
        $piecesrechanges = $em->getRepository('VelotnBundle:Piecesrechanges')->findAllPieceRechanges();
        //$productsLocation = $em->getRepository('VelotnBundle:ProduitsLocation')->findAllProductsLocation();
        $products = array();
        array_push($products,$velos,$accessoires,$piecesrechanges);
        //dump($products[0]);


        return $this->render('@Velotn/Front/shop.html.twig', array(
            'products' => $products
        ));
    }

    /**
     * @Route("/rent",name="rent")
     */
    public function showrentAction()
    {
        $em = $this->getDoctrine()->getManager();
        $productsLocation = $em->getRepository('VelotnBundle:ProduitsLocation')->findAllProductsLocation();
        $products = array();
        array_push($products,$productsLocation);
        return $this->render('@Velotn/Front/rent.html.twig', array(
            'products' => $products
        ));
    }
}
