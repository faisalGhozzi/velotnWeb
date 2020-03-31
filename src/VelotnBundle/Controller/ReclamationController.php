<?php

namespace VelotnBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VelotnBundle\Entity\Reclamation;
use VelotnBundle\Form\ReclamationType;

class ReclamationController extends Controller
{
    /**
     * @Route("/admin/AjouterReclamation",name="AjouterReclamation")
     * @param Request $request
     * @return Response
     */
    public Function NewAction(Request $request)
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class,$reclamation);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted())
        {
            $em= $this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();

            $this->redirectToRoute("afficherReclamation");
        }
        return $this->render("@Velotn/Back/Reclamation/new.html.twig",array('f'=>$form->createView()));

    }
    /**
     * @Route("/admin/afficherReclamation",name="afficherReclamation")
     */
    public Function IndexAction()
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository('VelotnBundle:Reclamation')->findAll();
        dump($reclamation);
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
