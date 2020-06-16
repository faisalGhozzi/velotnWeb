<?php
namespace VelotnBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;
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
     * @Route("/AjouterPanierQte",name="ajouterPanierQte")
     * @param Request $request
     * @return JsonResponse
     */
    public function AjouterPanierQteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $product = $em->getRepository(Produits::class)->find($request->request->get("idProduct"));
        $qte = $request->request->get("qte");
        $exist = $em->getRepository('VelotnBundle:Panier')->findOneBy(['produit'=>$request->request->get("idProduct")]);
        $u = $em->getRepository(User::class)->find($user);


        if($exist && ($exist->getUser()==$user))
        {
            $exist->setQte($exist->getQte()+$qte);
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
            $panier->setQte($qte);
            $panier->setPrixUnitaire($p->getPrix());
            $panier->setPrixTotal($p->getPrix()*$panier->getQte());

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
        $wish = $em->getRepository('VelotnBundle:Wishlist')->findByUser($user);

        dump($cart);
        return $this->render('@Velotn/Front/shopping-cart.html.twig',array(
            'cart' => $cart,
            //'produits'=>$produits,
            'wish' => $wish,
        ));

    }

    /**
     * @Route("/SupprimerPanier/{id}",name="supprimerPanier")
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */

    public function supprimerPanierAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $panier = $em->getRepository(Panier::class)->find($id);
        $em->remove($panier);
        $em->flush();

        return new JsonResponse();
    }

    /**
     * @Route("/ModifierPanier/{id}{qte}",name="modifierPanier")
     * @param $id
     * @param $qte
     * @return JsonResponse
     */
    public function ModifierPanierAction($id,$qte)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $cart = $em->getRepository(Panier::class)->find($id);

        $cart->setQte($qte);
        $cart->setPrixTotal($cart->getPrixUnitaire()*$qte);
        $em->flush();
        $usercart = $em->getRepository(Panier::class)->findBy(["user"=>$user]);

        $cartarray = null;

        $totalPrice = 0;

        foreach ($usercart as $item){
            $totalPrice = $totalPrice + $item->getPrixTotal();
        }

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($cart);
        return new JsonResponse(["cart"=>$formatted,"totalprice"=>$totalPrice]);

    }

    /**
     * @Route("/panierjson/",name="AfficherPanierJson")
     */

    public function afficherPanierJsonAction(){
        $panier = $this->getDoctrine()->getRepository(Panier::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $json = array();
        foreach($panier as $p){
            $temp = array(
                "id" => $p->getId(),
                "qte" => $p->getQte(),
                "prix_unitaire" => $p->getPrixUnitaire(),
                "prix_total" => $p->getPrixTotal(),
                "produit_id" => $p->getProduit()->getId(),
                "user_id" => $p->getUser()->getId()
            );
            array_push($json,$temp);
        }
        $formatted = $serializer->normalize($json);
        return new JsonResponse($formatted);
    }

    /**
     * @Route("/panierjson/new",name="AjouterPanierJson")
     * @param Request $request
     * @return JsonResponse
     */
    public function ajouterPanierJsonAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $panier = new Panier();
        $produit = $em->getRepository(Produits::class)->find($request->get('product'));
        $user = $em->getRepository(User::class)->find($request->get("user"));
        $panier->setUser($user);
        $panier->setProduit($produit);
        $panier->setPrixUnitaire($request->get("prix_unitaire"));
        $panier->setQte($request->get("qte"));
        $panier->setPrixTotal($request->get("prix_total"));
        $em->persist($panier);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($panier);
        return new JsonResponse($formatted);
    }

    /**
     * @Route("/panierjson/delete/{id}",name="SupprimerPanierJson")
     */
    public function supprimerPanierJsonAction($id){
        $panier = $this->getDoctrine()->getManager()->getRepository('VelotnBundle:Panier')->find($id);
        $this->getDoctrine()->getManager()->remove($panier);
        $this->getDoctrine()->getManager()->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($panier);
        return new JsonResponse($formatted);
    }



}