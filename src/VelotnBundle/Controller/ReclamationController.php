<?php

namespace VelotnBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VelotnBundle\Entity\Reclamation;
use VelotnBundle\Form\ReclamationType;

class ReclamationController extends Controller
{
    /**
     * @Route("/Reclamation",name="Reclamation")
     * @param Request $request
     * @return Response
     */
    public Function NewAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class,$reclamation);
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $reclamations=$em->getRepository('VelotnBundle:Reclamation')->findBy(['iduser'=>$user]);
        $cart = $em->getRepository('VelotnBundle:Panier')->findByUser($user);
        $wish = $em->getRepository('VelotnBundle:Wishlist')->findByUser($user);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted())
        {

            $reclamation->setEtat(false);
            $reclamation->setIduser($user);
            $em->persist($reclamation);
            $em->flush();

            $message = (new \Swift_Message('Velo TN'))
                ->setFrom('velotn.velotn@gmail.com')
                ->setTo($this->getUser()->getEmail())
                ->setDescription('Réclamation')
                ->setBody('Votre réclamation numéro'.$reclamation->getId().' a été envoyée vous recevrez un mail une fois traitée')


            ;

            $this->get('mailer')->send($message);


            return $this->redirectToRoute("Reclamation");
        }
        return $this->render("@Velotn/Front/reclamation.html.twig",array(
            'f'=>$form->createView(),
            'reclamations'=>$reclamations,
            'cart'=>$cart,
            'wish'=>$wish
        ));

    }
    /**
     * @Route("/admin/afficherReclamation",name="afficherReclamation")
     */
    public Function IndexAction()
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository('VelotnBundle:Reclamation')->findAll();
        return $this->render('@Velotn/Back/Reclamation/index.html.twig',array('r'=>$reclamation));
    }
    /**
     * @Route("/admin/DeleteR/{id}",name="deleteReclamation")
     */
    public Function DeleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->find($id);
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute('afficherReclamation');
    }
    /**
     * @Route("/Reclamation/DeleteR/{id}",name="deleteReclamationFront")
     */
    public Function DeleteFrontAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->find($id);
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute('Reclamation');
    }

    /**
     * @Route("/admin/UpdateR/{id}",name="UpdateReclamation")
     * @param $id
     * @return RedirectResponse|Response
     */
    public Function UpdateAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->find($id);
        if($reclamation->isEtat()==false)
        {
            $reclamation->setEtat(true);
            $em->flush();
            return $this->redirectToRoute('afficherReclamation');
        }else
        {
            $reclamation->setEtat(false);
            $em->flush();
            return $this->redirectToRoute('afficherReclamation');
        }
    }
}
