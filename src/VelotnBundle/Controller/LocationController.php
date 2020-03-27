<?php

namespace VelotnBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VelotnBundle\Entity\Location;

class LocationController extends Controller
{
    /**
     * @Route("/AjouterLocation",name="AjouterLocation")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */

public function AjouterLocationAction(Request $request)
{
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
}
