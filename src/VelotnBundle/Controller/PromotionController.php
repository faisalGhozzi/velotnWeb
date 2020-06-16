<?php

namespace VelotnBundle\Controller;

use Nexmo\Client;
use Nexmo\Client\Credentials\Basic;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VelotnBundle\Entity\Promotion;
use VelotnBundle\Form\PromotionType;

class PromotionController extends Controller
{
    /**
     * @Route("/admin/Promotion",name="promotion")
     * @param Request $request
     * @return Response
     */
    public function PromotionAction(Request $request)
    {
        $promos = $this->getDoctrine()->getRepository(Promotion::class)->findAll() ;
        $paginator = $this->get ('knp_paginator');
        $result = $paginator-> paginate (
            $promos,
            $request->query->getInt ('page', 1),
            $request-> query-> getInt ('limit', 2)
        );
        return $this->render('@Velotn/Back/Promotion/promotion.html.twig', array(
            'promos'=>$result
        ));



    }


    /**
     * @param $id
     * @Route("/admin/Promotion/Supprimer/{id}",name="Supprimer")
     * @return RedirectResponse
     */
    public function SupprimerPromoAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $promo = $em->getRepository(Promotion::class)->find($id);
        $em->remove($promo);
        $em->flush();
        return $this->redirectToRoute('promotion');
    }


    /**
     * @Route("/admin/AjouterPromo",name="AjouterPromo")
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws Client\Exception\Exception
     * @throws Client\Exception\Request
     * @throws Client\Exception\Server
     */

    public function AjouterPromoAction(Request $request)
    {

        $promo = new Promotion();
        $form = $this->createForm(PromotionType::class,$promo);
        $form = $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em= $this->getDoctrine()->getManager();
            $em->persist($promo);
            $em->flush();
            $basic  = new Basic('bedc050f', 'B1Jo6yVQB19C3q9F');
            $client = new Client($basic);

            $message = $client->message()->send([
                'to' => '21624030600',
                'from' => 'Vonage SMS API',
                'text' => 'Voici le code Promo : '.$promo->getType().' De pourcentage : '.$promo->getTaux().'%'
            ]);
            return $this->redirectToRoute('promotion');

        }

        return $this->render('@Velotn/Back/Promotion/ajouterPromo.html.twig',array(
           'form'=>$form->createView()
        ));


    }

    /**
     * @param Request $request
     * @param $id
     * @return Response
     * @Route("/admin/Promotion/Modifer/{id}",name="Modifier")
     */
    public function ModifierPromoAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();

        $promo = $em->getRepository(Promotion::class)->find($id);

        if($request->isMethod("POST"))
        {
            $promo->setType($request->get('type'));
            $promo->setTaux($request->get('taux'));
            $em->flush();
            return $this->redirectToRoute('promotion');
        }
        return $this->render('@Velotn/Back/Promotion/modifierPromo.html.twig', array(
            'promos'=>$promo
        ));

    }

    /**
     * @Route("/Promo",name="promo")
     * @param Request $request
     * @return JsonResponse
     */
    public function promoAction(Request $request)
    {
        $codePromo = $request->request->get("codepromo");
        $em = $this->getDoctrine()->getManager();
        $promo = $em->getRepository(Promotion::class)->findOneBy(array(
           'type'=>$codePromo
        ));

        if($promo)
        {
            $data = [
                'idPromo'=>$promo->getId(),
                'taux'=>$promo->getTaux(),
                'erreur'=>""
            ];
            return new JsonResponse($data);
        }
    }

    /**
     * @Route("/mail",name="mail")
     * @return void
     */
    public function mailAction()
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('khalil.bouchnek@esprit.tn')
            ->setTo('omar.trabelsi.1@esprit.tn')
            ->setBody(
                "TEST"
            );

        $this->get('mailer')->send($message);


    }




}
