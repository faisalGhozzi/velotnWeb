<?php

namespace VelotnBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use VelotnBundle\Entity\Location;
use VelotnBundle\Entity\Produits;
use VelotnBundle\Entity\ProduitsLocation;

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
    $produit = $em->getRepository(Produits::class)->find($request->request->get('idProduit'));
    $promo= $em->getRepository(Promotion::class)->find($request->request->get('idPromo'));



    $loction->setDateDebut(new \DateTime($request->request->get('dated')));
    $loction->setDateFin(new \DateTime($request->request->get('datef')));
    $loction->setPrixtotal($request->request->get('prixt'));
    $loction->setIdPromo($promo);
    $loction->setIdProduit($produit);
    $loction->setIdUser($user);
    $em->persist($loction);
    $em->flush();
    return $this->redirectToRoute('location');

}
    /**
     * @Route("/Location",name="location")
     */
    public function LocationAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $locations= $this->getDoctrine()->getRepository(Location::class)->findAll();
        $produitsLocation= $this->getDoctrine()->getRepository(ProduitsLocation::class)->findAll();
        $cart = $em->getRepository('VelotnBundle:Panier')->findByUser($user);
        $wish = $em->getRepository('VelotnBundle:Wishlist')->findByUser($user);

        /*$ids=array();
        foreach ($cart as $item)
        {
            array_push($ids,($item->getProduit()->getId()));
        }*/
        return $this->render('@Velotn/Front/listelocation.html.twig', array(
            'locations'=>$locations,
            'produits'=>$produitsLocation,
            'cart' => $cart,
            'wish' => $wish
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
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $cart = $em->getRepository('VelotnBundle:Panier')->findByUser($user);
        $wish = $em->getRepository('VelotnBundle:Wishlist')->findByUser($user);
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
            'promo'=>$promo,
              'cart' => $cart,
            'wish' => $wish
        ));




    }

    /**
     * @Route("/Date",name="checkdate")
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function checkdateAction(Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        $location= $em->getRepository(Location::class)->findOneBy(['idProduit'=>$request->request->get('idProduit')]);
        $dated = new \DateTime($request->request->get('datedeb'));
        $datef = new \DateTime($request->request->get('datefi'));
        if($location)
        {



            if($dated >= new \DateTime('now') && new \DateTime('now') > $location->getDateFin() )
            {

                // ynajem
                $reponse=['error'=>'Date Valide'];
                return new JsonResponse($reponse);
            }

            if($dated <= new \DateTime('now'))
            {
                // maynajmch
                $reponse=['error'=>'Date Invalide'];
                return new JsonResponse($reponse);
            }

            if($location->getDateDebut() >= $dated && $location->getDateFin() >= $dated )
            {
                // maynajemch y'ajouti
                $reponse=['error'=>'Date Invalide'];
                return new JsonResponse($reponse);
            }




            if($dated > $location->getDateFin())
            {
                //ynajem
                $reponse=['error'=>'Date Valide'];
                return new JsonResponse($reponse);
            }
            if($dated>$datef)
            {
                $reponse=['error'=>'Date Invalide'];
                return new JsonResponse($reponse);
            }

        }else
        {
            if($dated>$datef)
            {
                $reponse=['error'=>'Date Invalide'];
                return new JsonResponse($reponse);
            }
            if($dated < new \DateTime('now'))
            {
                // maynajmch
                $reponse=['error'=>'Date Invalide'];
                return new JsonResponse($reponse);
            }

            $reponse=['error'=>'Date Valide'];
            return new JsonResponse($reponse);


        }


    }

    /**
     * @Route("/admin/map",name="map")
     *
     */
    public function mapAction()
    {
        return $this->render('@Velotn/Back/Location/map.html.twig');
    }

    /**
     * @Route("/admin/calendar", name="booking_calendar", methods={"GET"})
     */
    public function calendarAction()
    {
        $events = $this->getDoctrine()->getRepository(Location::class)->findAll();
        return $this->render('@Velotn/Back/Location/calendrier.html.twig',array(
            'events'=>$events
        ));
    }


}
