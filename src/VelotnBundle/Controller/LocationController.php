<?php

namespace VelotnBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VelotnBundle\Entity\Location;
use VelotnBundle\Entity\Produits;
use VelotnBundle\Entity\ProduitsLocation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use VelotnBundle\Entity\Promotion;


class LocationController extends Controller
{
    /**
     *
     * @Route("/AjouterLocation",name="AjouterLocation")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */

public function AjouterLocationAction(Request $request)
{
    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    $loction = new Location() ;
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $em=$this->getDoctrine()->getManager();



    $loction->setDateDebut(new \DateTime($request->request->get('dated')));
    $loction->setDateFin(new \DateTime($request->request->get('datef')));
    $loction->setPrixtotal($request->request->get('prixt'));
    $loction->setIdPromo($request->request->get('idPromo'));
    $loction->setIdProduit($request->request->get('idProduit'));
    $loction->setIdUser($user->getId());
    $em->persist($loction);
    $em->flush();
    return $this->redirectToRoute('index');

}
    /**
     * @Route("/Location",name="location")
     */
    public function LocationAction()
    {
        $em = $this->getDoctrine()->getManager();
        $locations= $this->getDoctrine()->getRepository(Location::class)->findAll() ;
        $produitsLocation= $this->getDoctrine()->getRepository(ProduitsLocation::class)->findAllProductsLocation();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $cart = $em->getRepository('VelotnBundle:Panier')->findByUser($user);
        $ids=array();
        foreach ($cart as $item)
        {
            array_push($ids,($item->getProduit()->getId()));
        }
        return $this->render('@Velotn/Front/listelocation.html.twig', array(
            'locations'=>$locations,
            'produits'=>$produitsLocation,
            'cart' => $cart
        ));
    }

    /**
     * @param $id
     * @Route("/SupprimerLocation/{id}",name="supprimerloco")
     * @return RedirectResponse
     */
    public function SupprimerLocationAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $location = $em->getRepository(Location::class)->find($id);
        $em->remove($location);
        $em->flush();
        return $this->redirectToRoute('location');
    }

    /**
     * @param Request $request
     * @param $id
     * @Route("/ModifierLocation/{id}",name="modifierloco")
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function ModifierLocationAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();

        $loctions= $em->getRepository(Location::class)->find($id);
        $produit= $this->getDoctrine()->getRepository(ProduitsLocation::class)->find($loctions->getIdProduit());
        if($loctions->getIdPromo())
        {
            $promo = $this->getDoctrine()->getRepository(Promotion::class)->find($loctions->getIdPromo());
        }else
        {
            $promo=null;
        }


        if($request->isMethod("POST")) {
            $loctions->setDateDebut(new \DateTime($request->request->get('dated')));
            $loctions->setDateFin(new \DateTime($request->request->get('datef')));
            $loctions->setPrixtotal($request->request->get('prixt'));
            $em->flush();
            return $this->redirectToRoute('location');
        }
        return $this->render('@Velotn/Front/ModifierLocation.html.twig', array(
            'locations'=>$loctions,
            'produit'=>$produit,
            'promo'=>$promo
        ));




    }

}
