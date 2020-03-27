<?php

namespace VelotnBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
    /**
     * @Route("/Location",name="location")
     */
    public function PromotionAction()
    {
        $locations= $this->getDoctrine()->getRepository(Location::class)->findAll() ;
        return $this->render('@Velotn/Front/listelocation.httml.twig', array(
            'locations'=>$locations
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

        if($request->isMethod("POST")) {
            $loctions->setDateDebut(new \DateTime($request->request->get('dated')));
            $loctions->setDateFin(new \DateTime($request->request->get('datef')));
            $em->flush();
            return $this->redirectToRoute('location');
        }
        return $this->render('@Velotn/Front/ModifierLocation.html.twig', array(
            'locations'=>$loctions
        ));




    }

}
