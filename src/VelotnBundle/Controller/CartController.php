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
        $username = $this->getUser()->getUsername();
        /*$user = $em->getRepository(User::class)->findOneBy(array(
            'username'=>$username
        ));*/
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $product = $em->getRepository(Produits::class)->find($request->request->get("idProduct"));
        dump($product);

        $p= new Produits();

        $p->setId($product->getId());
        $p->setNomprod($product->getNomprod());
        $p->setDescription($product->getDescription());
        $p->setPrix($product->getPrix());
        $p->setQuantite($product->getQuantite());
        $p->setImgUrl($product->getImgUrl());

        $panier = new Panier();
        $panier->setProduit($product->getId());
        $panier->setUser($user->getId());
        $panier->setQte(1);
        $panier->setPrixUnitaire($p->getPrix());
        $panier->setPrixTotal($panier->getPrixUnitaire()*$panier->getQte());

        $em->persist($panier);
        $em->flush();

        return new JsonResponse();

    }

}