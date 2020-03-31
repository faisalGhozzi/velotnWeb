<?php

namespace VelotnBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
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

}