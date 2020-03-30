<?php
namespace VelotnBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use VelotnBundle\Entity\Panier;
use VelotnBundle\Entity\Produits;
use VelotnBundle\Entity\User;

class CartController extends Controller{

    /**
     * @Route("/AjouterPanier",name="ajouterPanier")
     * @param Request $request
     * @return JsonResponse
     */
    public function AjouterPanierAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $product = $em->getRepository(Produits::class)->find($request->request->get("idProduct"));
        $exist = $em->getRepository('VelotnBundle:Panier')->findOneBy(['produit'=>$request->request->get("idProduct")]);
        $u = $em->getRepository(User::class)->find($user);


        if($exist && ($exist->getUser()==$user))
        {
            $exist->setQte($exist->getQte()+1);
            $exist->setPrixTotal($exist->getQte()*$exist->getPrixUnitaire());
            $em->flush();
            return new JsonResponse();
        }
        else
        {


        $p= new Produits();

        $p->setId($product->getId());
        $p->setNomprod($product->getNomprod());
        $p->setDescription($product->getDescription());
        $p->setPrix($product->getPrix());
        $p->setQuantite($product->getQuantite());
        $p->setImgUrl($product->getImgUrl());

        $panier = new Panier();
        $panier->setProduit($product);
        $panier->setUser($u);
        $panier->setQte(1);
        $panier->setPrixUnitaire($p->getPrix());
        $panier->setPrixTotal($panier->getPrixUnitaire()*$panier->getQte());

        $em->persist($panier);
        $em->flush();

            return new JsonResponse();
        }

    }

    /**
     * @Route("/Cart",name="shoppingcart")
     */
    public function showcartAction(){
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $cart = $em->getRepository('VelotnBundle:Panier')->findByUser($user);
        $ids=array();
        foreach ($cart as $item)
        {
           array_push($ids,($item->getProduit()->getId()));
        }

        $produits = $em->getRepository('VelotnBundle:Produits')->findBy(['id'=>$ids]);


        dump($cart);
        return $this->render('@Velotn/Front/shopping-cart.html.twig',array(
            'cart' => $cart,
            'produits'=>$produits,
        ));

    }

    /**
     * @Route("/SupprimerPanier",name="supprimerPanier")
     * @param Request $request
     * @return JsonResponse
     */

    public function supprimerPanierAction(Request $request){

    }



}