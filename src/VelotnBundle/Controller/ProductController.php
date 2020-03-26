<?php

namespace VelotnBundle\Controller;

use Doctrine\ORM\Query\Expr\Select;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VelotnBundle\Entity\Accessoires;
use VelotnBundle\Entity\Piecesrechanges;
use VelotnBundle\Entity\Produits;
use VelotnBundle\Entity\ProduitsLocation;
use VelotnBundle\Entity\Velos;
use VelotnBundle\Form\ProduitsType;

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
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository("VelotnBundle:Velos")->find($prod);
        if($produit == null)
            $produit = $em->getRepository("VelotnBundle:Piecesrechanges")->find($prod);
        if($produit == null)
            $produit = $em->getRepository("VelotnBundle:Accessoires")->find($prod);

        return $this->render('@Velotn/Front/buyproduct.html.twig',array(
            'produit' => $produit
        ));
    }

    /**
     * @Route("/admin/AjouterProduit",name="AjouterProduit")
     * @param Request $request
     * @return Response
     */
    public function ajoutProduitAction(Request $request)
    {
        $form=$this->createForm(ProduitsType::class);
        $form= $form->handleRequest($request);
        $produit = new Produits();
        $Velo= new Velos();
        $PieceR = new Piecesrechanges();
        $Acc= new Accessoires();
        $VeloL= new ProduitsLocation();

        $em = $this->getDoctrine()->getManager();


        if($form->isSubmitted())
        {

        dump($request->request);
        $produit->setNomprod($request->request->get('velotnbundle_produits')['nomprod']);
        $produit->setDescription($request->request->get("velotnbundle_produits")['description']);
        $produit->setPrix($request->request->get("velotnbundle_produits")['prix']);
        $produit->setQuantite($request->request->get("velotnbundle_produits")['quantite']);
        $produit->setImgUrl($request->request->get("velotnbundle_produits")['imgUrl']);
            $em->persist($produit);
            $em->flush();


            if($request->get("typeProduit")=="Velo")
            {
                $Velo->setId($produit);
                $Velo->setMarque($request->request->get("velotnbundle_produits")['marque']);
                $Velo->setType($request->request->get("velotnbundle_produits")['type']);
                $em->persist($Velo);
                $em->flush();

            }

            if($request->get("typeProduit")=="PieceRechange")
            {
                $PieceR->setId($produit);
                $PieceR->setMarque($request->request->get("velotnbundle_produits")['marque']);
                $PieceR->setType($request->request->get("velotnbundle_produits")['type']);
                $em->persist($PieceR);
                $em->flush();

            }

            if($request->get("typeProduit")=="Accessoire")
            {
                $Acc->setId($produit);
                $Acc->setMarque($request->request->get("velotnbundle_produits")['marque']);
                $Acc->setType($request->request->get("velotnbundle_produits")['type']);
                $em->persist($Acc);
                $em->flush();
            }

            if($request->get("typeProduit")=="Velo a Louer")
            {
                $VeloL->setId($produit);
                $VeloL->setMarque($request->request->get("velotnbundle_produits")['marque']);
                $VeloL->setType($request->request->get("velotnbundle_produits")['type']);
                $em->persist($VeloL);
                $em->flush();
            }

        }

        return $this->render('@Velotn/Back/Produit/ajouterProduit.html.twig',array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @Route("/admin/Produits/",name="listeProduits")
     */
    public function ProduitsAction()
    {
        $em=$this->getDoctrine();

        $velos = $em->getRepository('VelotnBundle:Velos')->findAllVelos();
        $accessoires = $em->getRepository('VelotnBundle:Accessoires')->findAllAccessoires();
        $piecesrechanges = $em->getRepository('VelotnBundle:Piecesrechanges')->findAllPieceRechanges();
        $productsLocation = $em->getRepository('VelotnBundle:ProduitsLocation')->findAllProductsLocation();

        return $this->render('@Velotn/Back/Produit/Produits.html.twig', array(
            'velos' => $velos,
            'accessoires'=>$accessoires,
            'pieces'=>$piecesrechanges,
            'location'=>$productsLocation
        ));

    }

    /**
     * @Route("/admin/Produits/supprimerVelo/{id}",name="supprimerVelo")
     */
    public function supprimerVeloAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Produits::class)->find($id);
        $velo = $em->getRepository(Velos::class)->find($id);

        $em->remove($produit);
        $em->remove($velo);
        $em->flush();
        return $this->redirectToRoute('listeProduits');



    }
    /**
     * @Route("/admin/Produits/supprimerAccessoire/{id}",name="supprimerAccessoire")
     */
    public function supprimerAccessoireAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Produits::class)->find($id);
        $acc = $em->getRepository(Accessoires::class)->find($id);
        $em->remove($produit);
        $em->remove($acc);
        $em->flush();
        return $this->redirectToRoute('listeProduits');

    }
    /**
     * @Route("/admin/Produits/supprimerPieceR/{id}",name="supprimerPieceR")
     */
    public function supprimerPieceRAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Produits::class)->find($id);
        $piece = $em->getRepository(Piecesrechanges::class)->find($id);
        $em->remove($produit);
        $em->remove($piece);
        $em->flush();
        return $this->redirectToRoute('listeProduits');

    }

    /**
     * @Route("/admin/Produits/supprimerVelol/{id}",name="supprimerVelol")
     */
    public function supprimerVelolRAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Produits::class)->find($id);
        $velol= $em->getRepository(ProduitsLocation::class)->find($id);
        $em->remove($produit);
        $em->remove($velol);
        $em->flush();
        return $this->redirectToRoute('listeProduits');

    }
}
