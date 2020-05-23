<?php

namespace VelotnBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VelotnBundle\Entity\Don;
use VelotnBundle\Form\DonType;

class ConfirmPayment extends Controller{
    /**
     * @Route("/confirmpayment",name="confirmpayment")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Stripe\Exception\ApiErrorException
     */

    public function confirmPaymentAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $cart = $em->getRepository('VelotnBundle:Panier')->findByUser($user);
        $wish = $em->getRepository('VelotnBundle:Wishlist')->findByUser($user);

        /*$montantDt = $request->request->get("montantDt");
        dump($montantDt);*/

        $montantDt = 1906;

        $don = new Don();
        $form = $this->createForm(DonType::class,$don);
        $form->handleRequest($request);
        $don->setSomme($montantDt);
        $don->setDateDon(new DateTime('now'));
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($don);
            $em->flush();
            return $this->redirectToRoute('index');
        }

        \Stripe\Stripe::setApiKey('sk_test_co5CoSxhQlkaWtFYu8ytyPRE00v7PWGVhL');

        $intent = \Stripe\PaymentIntent::create([
            'amount' => 1099,
            'currency' => 'usd',
            // Verify your integration in this guide by including this parameter
            'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);

        return $this->render('@Velotn/Front/thankyousupport.html.twig',array(
            'cart'=>$cart,
            'wish'=>$wish
        ));
    }
}