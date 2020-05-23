<?php

namespace VelotnBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use VelotnBundle\Entity\Produits;
use VelotnBundle\Entity\User;
use VelotnBundle\Entity\Wishlist;

class WishlistController extends Controller{
    /**
     * @Route("/AjouterWishlist",name="ajouterWishlist")
     * @param Request $request
     * @return JsonResponse
     */
    public function AjouterWishlistAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $product = $em->getRepository(Produits::class)->find($request->request->get("idProduct"));
        $u = $em->getRepository(User::class)->find($user);


        $wishlist = new Wishlist();
        $wishlist->setProduct($product);
        $wishlist->setUser($u);

        $em->persist($wishlist);
        $em->flush();

        return new JsonResponse();

    }

    /**
     * @Route("/wishlist",name="wishlist")
     * @return Response
     */

    public function showWishlist(){
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $wish = $em->getRepository('VelotnBundle:Wishlist')->findByUser($user);

        //$idc = array();

        /*foreach ($wish as $item){
            array_push($idc,($item->getProduct()->getId()));
        }*/
        dump($wish);

        $cart = $em->getRepository('VelotnBundle:Panier')->findByUser($user);

        /*$ids = array();
        foreach ($cart as $item)
        {
            array_push($idc,($item->getProduit()->getId()));
        }*/

        return $this->render('@Velotn/Front/wishlist.html.twig',array(
            'wish'=>$wish,
            'cart'=>$cart
        ));
    }

    /**
     * @Route("/SupprimerWishlist/{id}",name="supprimerWishlist")
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */

    public function supprimerWishlistAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $wishlist = $em->getRepository(Wishlist::class)->find($id);
        $em->remove($wishlist);
        $em->flush();

        return new JsonResponse();
    }

    /**
     * @Route("/wishlistjson/",name="AfficherWishlistJson")
     */

    public function afficherWishlistJsonAction(){
        $wishlist = $this->getDoctrine()->getRepository(Wishlist::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $json = array();
        foreach ($wishlist as $w){
            $temp = array(
                "id" => $w->getId(),
                "product_id"=>$w->getProduct()->getId(),
                "user_id"=>$w->getUser()->getId()
            );
            array_push($json,$temp);
        }
        $formatted = $serializer->normalize($json);
        return new JsonResponse($formatted);
    }

    /**
     * @Route("/wishlistjson/new",name="AjouterWishlistJson")
     * @param Request $request
     * @return JsonResponse
     */

    public function ajouterWishlistJsonAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $wishlist = new Wishlist();
        $produit = $em->getRepository(Produits::class)->find($request->get("product"));
        $user = $em->getRepository(User::class)->find($request->get("user"));
        $wishlist->setProduct($produit);
        $wishlist->setUser($user);
        $em->persist($wishlist);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($wishlist);
        return new JsonResponse($formatted);
    }

    /**
     * @Route("/wishlistjson/delete/{id}",name="DeleteWishlistJson")
     */

    public function deleteWishlistJsonAction($id){
        $wishlist = $this->getDoctrine()->getManager()
            ->getRepository('VelotnBundle:Wishlist')
            ->find($id);
        $this->getDoctrine()->getManager()->remove($wishlist);
        $this->getDoctrine()->getManager()->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($wishlist);
        return new JsonResponse($formatted);
    }
}