<?php

namespace VelotnBundle\Controller;

use Doctrine\ORM\Query\Expr\Select;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $velos = $em->getRepository('VelotnBundle:Velos')->findAllVelos();
        $accessoires = $em->getRepository('VelotnBundle:Accessoires')->findAllAccessoires();
        $piecesrechanges = $em->getRepository('VelotnBundle:Piecesrechanges')->findAllPieceRechanges();
        $products = array();
        array_push($products,$velos,$accessoires,$piecesrechanges);

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $cart = $em->getRepository('VelotnBundle:Panier')->findByUser($user);
        $wish = $em->getRepository('VelotnBundle:Wishlist')->findByUser($user);
        /*$ids=array();
        foreach ($cart as $item)
        {
            array_push($ids,($item->getProduit()->getId()));
        }*/

        return $this->render('@Velotn/Front/shop.html.twig', array(
            'products' => $products,
            'cart' => $cart,
            'wish' => $wish
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

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $cart = $em->getRepository('VelotnBundle:Panier')->findByUser($user);
        $wish = $em->getRepository('VelotnBundle:Wishlist')->findByUser($user);
        /*$ids=array();
        foreach ($cart as $item)
        {
            array_push($ids,($item->getProduit()->getId()));
        }*/

        return $this->render('@Velotn/Front/rent.html.twig', array(
            'products' => $products,
            'cart' => $cart,
            'wish' => $wish
        ));
    }

    /**
     * @Route("/productrent/{prod}",name="viewprodrent")
     */
    public function viewprodrentAction($prod){
        $myId = $this->get('nzo_url_encryptor')->decrypt($prod);
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository("VelotnBundle:ProduitsLocation")->find($myId);
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $cart = $em->getRepository('VelotnBundle:Panier')->findByUser($user);
        $wish = $em->getRepository('VelotnBundle:Wishlist')->findByUser($user);

        return $this->render('@Velotn/Front/rentproduct.html.twig',array(
            'produit' => $produit,
            'cart' => $cart,
            'wish' => $wish
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
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $cart = $em->getRepository('VelotnBundle:Panier')->findByUser($user);
        $wish = $em->getRepository('VelotnBundle:Wishlist')->findByUser($user);

        return $this->render('@Velotn/Front/buyproduct.html.twig',array(
            'produit' => $produit,
            'cart' => $cart,
            'wish' => $wish
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
            return $this->redirectToRoute('listeProduits');

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

    /**
     * @Route("/admin/Produits/modifierProduit/",name="modifierProduit")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function modifierProduitAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form=$this->createForm(ProduitsType::class);
        $form= $form->handleRequest($request);




        if($form->isSubmitted())
        {
            $produits=$em->getRepository(Produits::class)->findAll();
            $produit = $em->getRepository(Produits::class)->find($request->request->get('produit'));
            $Velo= $em->getRepository(Velos::class)->find($request->request->get('produit'));
            $a=$em->getRepository(Accessoires::class)->find($request->request->get('produit'));
            $vl=$em->getRepository(ProduitsLocation::class)->find($request->request->get('produit'));
            $pr=$em->getRepository(Piecesrechanges::class)->find($request->request->get('produit'));

            $produit->setNomprod($request->request->get('velotnbundle_produits')['nomprod']);
            $produit->setDescription($request->request->get("velotnbundle_produits")['description']);
            $produit->setPrix($request->request->get("velotnbundle_produits")['prix']);
            $produit->setQuantite($request->request->get("velotnbundle_produits")['quantite']);
            $produit->setImgUrl($request->request->get("velotnbundle_produits")['imgUrl']);

            $em->flush();


            if(!empty($Velo))
            {
                $Velo->setId($produit);
                $Velo->setMarque($request->request->get("velotnbundle_produits")['marque']);
                $Velo->setType($request->request->get("velotnbundle_produits")['type']);
                $em->flush();
            }

            if(!empty($a))
            {
                $a->setId($produit);
                $a->setMarque($request->request->get("velotnbundle_produits")['marque']);
                $a->setType($request->request->get("velotnbundle_produits")['type']);
                $em->flush();
            }

            if(!empty($vl))
            {
                $vl->setId($produit);
                $vl->setMarque($request->request->get("velotnbundle_produits")['marque']);
                $vl->setType($request->request->get("velotnbundle_produits")['type']);
                $em->flush();
            }

            if(!empty($pr))
            {
                $pr->setId($produit);
                $pr->setMarque($request->request->get("velotnbundle_produits")['marque']);
                $pr->setType($request->request->get("velotnbundle_produits")['type']);
                $em->flush();
            }

            return $this->redirectToRoute('listeProduits');

        }

        return $this->render('@Velotn/Back/Produit/modifierProduit.html.twig',array(
           'form'=>$form->createView()
        ));
    }

    /**
     * @Route("/admin/getProducts",name="getProducts")
     */
    public function getProductsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository(Produits::class)->findAll();
        $ids=array();
        $nomp=array();

        foreach ($products as $item)
        {
            array_push($ids,($item->getId()));

            array_push($nomp,($item->getNomprod()));
        }
        $produits=array([$ids,$nomp]);
        return new JsonResponse($produits);

    }

    /**
     * @Route("/admin/getProduct",name="getProduct")
     */
    public function getProductAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $p = $em->getRepository(Produits::class)->find($request->request->get('id'));
        $v= $em->getRepository(Velos::class)->find($request->request->get('id'));
        $a=$em->getRepository(Accessoires::class)->find($request->request->get('id'));
        $vl=$em->getRepository(ProduitsLocation::class)->find($request->request->get('id'));
        $pr=$em->getRepository(Piecesrechanges::class)->find($request->request->get('id'));
        $product=array();

        if(!empty($v))
        {
            $product=array("nom"=>$p->getNomprod(),"description"=>$p->getDescription(),"quantite"=>$p->getQuantite(),"prix"=>$p->getPrix(),"image"=>$p->getImgUrl(),"marque"=>$v->getMarque(),"type"=>$v->getType());
        }

        if(!empty($a))
        {
            $product=array("nom"=>$p->getNomprod(),"description"=>$p->getDescription(),"quantite"=>$p->getQuantite(),"prix"=>$p->getPrix(),"image"=>$p->getImgUrl(),"marque"=>$a->getMarque(),"type"=>$a->getType());
        }

        if(!empty($vl))
        {
            $product=array("nom"=>$p->getNomprod(),"description"=>$p->getDescription(),"quantite"=>$p->getQuantite(),"prix"=>$p->getPrix(),"image"=>$p->getImgUrl(),"marque"=>$vl->getMarque(),"type"=>$vl->getType());
        }

        if(!empty($pr))
        {
            $product=array("nom"=>$p->getNomprod(),"description"=>$p->getDescription(),"quantite"=>$p->getQuantite(),"prix"=>$p->getPrix(),"image"=>$p->getImgUrl(),"marque"=>$pr->getMarque(),"type"=>$pr->getType());
        }


        return new JsonResponse($product);

    }
}
