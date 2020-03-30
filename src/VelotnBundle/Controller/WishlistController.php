<?php

namespace VelotnBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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

        /*$p= new Produits();

        $p->setId($product->getId());
        $p->setNomprod($product->getNomprod());
        $p->setDescription($product->getDescription());
        $p->setPrix($product->getPrix());
        $p->setQuantite($product->getQuantite());
        $p->setImgUrl($product->getImgUrl());*/

        $wishlist = new Wishlist();
        $wishlist->setProduit($product);
        $wishlist->setUser($u);

        $em->persist($wishlist);
        $em->flush();

        return new JsonResponse();

    }

}