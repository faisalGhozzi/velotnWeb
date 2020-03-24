<?php

namespace VelotnBundle\Controller;

use DateTime;
use VelotnBundle\Form\DonType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VelotnBundle\Entity\Don;

class DonController extends Controller
{
    /**
     * @Route("/ajouter",name="ajouterdon")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function ajouterAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $don = new Don();
        $form = $this->createForm(DonType::class,$don);
        $form->handleRequest($request);
        $don->setDateDon(new DateTime('now'));
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($don);
            $em->flush();
            return $this->redirectToRoute('index');
        }

        return $this->render('@Velotn/Front/don.html.twig', array(
            'form' => $form->createView()
        ));
    }
    /**
     * @Route("/afficher")
     */
    public function afficherAction()
    {
        /*return $this->render('VelotnBundle:Don:afficher.html.twig', array(
            // ...
        ));*/
    }

}