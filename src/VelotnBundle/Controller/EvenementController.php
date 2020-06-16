<?php

namespace VelotnBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VelotnBundle\Entity\Evenement;
use VelotnBundle\Form\EvenementType;

class EvenementController extends Controller
{
    /**
     * @Route("/admin/afficherEventBack",name="afficherEventBack")
     */
    public Function IndexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $events= $em->getRepository('VelotnBundle:Evenement')->findAll();
        return $this->render('@Velotn/Back/Evenement/Evenements.html.twig',array('e'=>$events));
    }

    /**
     * @Route("/Evenements",name="afficherEventFront")
     */
    public Function IndexFrontAction()
    {
        $em = $this->getDoctrine()->getManager();
        $events= $em->getRepository('VelotnBundle:Evenement')->findAll();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $cart = $em->getRepository('VelotnBundle:Panier')->findByUser($user);
        $wish = $em->getRepository('VelotnBundle:Wishlist')->findByUser($user);
        return $this->render('@Velotn/Front/events.html.twig',array(
            'events'=>$events,
            'cart'=>$cart,
            'wish'=>$wish
        ));
    }

    /**
     * @Route("/admin/DeleteEvent/{id}",name="deleteEvent")
     */
    public Function DeleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository(Evenement::class)->find($id);
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute('afficherEventBack');
    }

    /**
     * @Route("/admin/UpdateEvent/{id}",name="UpdateEvent")
     * @param $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public Function UpdateAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $event=$em->getRepository(Evenement::class)->find($id);
        $form=$this->createForm(EvenementType::class,$event);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('afficherEventBack');
        }
        return $this->render('@Velotn/Back/Evenement/Update.html.twig',array('f'=>$form->createView()));
    }

    /**
     * @Route("/admin/AjouterEvenement",name="AjouterEvenement")
     * @param Request $request
     * @return Response
     */
    public Function NewAction(Request $request)
    {
        $evenement=new Evenement();
        $form =$this ->createForm(EvenementType::class,$evenement);
        $form-> handleRequest($request);
        if ( $form->isSubmitted() && $form ->isValid() )
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();

            $this->redirectToRoute("afficherEventBack");
        }
        return $this->render("@Velotn/Back/Evenement/new.html.twig",array('f'=>$form->createView()));
    }
}
