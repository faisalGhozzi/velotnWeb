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

    /**
     * @Route("/product/{prod}",name="viewprod")
     */
    public function viewprodAction($prod){
        $myId = $this->get('nzo_url_encryptor')->decrypt($prod);
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository("VelotnBundle:Velos")->find($myId);
        if($produit == null)
            $produit = $em->getRepository("VelotnBundle:Piecesrechanges")->find($myId);
        if($produit == null)
            $produit = $em->getRepository("VelotnBundle:Accessoires")->find($myId);

        return $this->render('@Velotn/Front/buyproduct.html.twig',array(
            'produit' => $produit
        ));
    }

    /**
     * @Route("/productrent/{prod}",name="viewprodrent")
     */
    public function viewprodrentAction($prod){
        $myId = $this->get('nzo_url_encryptor')->decrypt($prod);
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository("VelotnBundle:ProduitsLocation")->find($myId);

        return $this->render('@Velotn/Front/rentproduct.html.twig',array(
            'produit' => $produit
        ));
    }
}
