<?php

namespace VelotnBundle\Controller;

use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
     */
    public function PromotionAction()
    {
        $promos = $this->getDoctrine()->getRepository(Promotion::class)->findAll() ;
        return $this->render('@Velotn/Back/Promotion/promotion.html.twig', array(
            'promos'=>$promos
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
