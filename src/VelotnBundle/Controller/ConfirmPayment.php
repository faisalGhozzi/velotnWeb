<?php

namespace VelotnBundle\Controller;

use DateTime;
use Stripe\Exception\ApiErrorException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VelotnBundle\Entity\Don;
use VelotnBundle\Form\DonType;

class ConfirmPayment extends Controller{

    function convertCurrency($amount,$from_currency,$to_currency){
        $apikey = 'ff1f8f42269b26d0dcdc';

        $from_Currency = urlencode($from_currency);
        $to_Currency = urlencode($to_currency);
        $query =  "{$from_Currency}_{$to_Currency}";

        $json = file_get_contents("https://free.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey={$apikey}");
        $obj = json_decode($json, true);

        $val = floatval($obj["$query"]);


        $total = $val * $amount;
        return number_format($total, 2, '.', '');
    }

    /**
     * @Route("/confirmpayment",name="confirmpayment")
     * @param Request $request
     * @return Response
     * @throws ApiErrorException
     */

    public function confirmPaymentAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $cart = $em->getRepository('VelotnBundle:Panier')->findByUser($user);
        $wish = $em->getRepository('VelotnBundle:Wishlist')->findByUser($user);

        $montant = $request->request->get("montant");

        $currency = $request->request->get("cur-select");

        $montantUSD = null;
        $montantTND = null;

        if($currency == 'TND'){
            $montantTND = $montant;
            $montantUSD = $this->convertCurrency($montant,'TND','USD');
        }elseif ($currency == 'USD'){
            $montantUSD = $montant;
            $montantTND = $this->convertCurrency($montant,'USD','TND');
        }

        //Static in case API server is down

        /*if($currency == 'TND'){
            $montantTND = $montant;
            $montantUSD = $montant * 0.350477;
            $montantUSD = number_format($montantUSD, 2, '.', '');
        }elseif ($currency == 'USD'){
            $montantUSD = $montant;
            $montantTND = $montant * 2.85325;
            $montantTND = number_format($montantTND, 2, '.', '');
        }*/

        $don = new Don();
        $don->setSomme($montantTND);
        $don->setDateDon(new DateTime('now'));
        $em->persist($don);
        $em->flush();

        \Stripe\Stripe::setApiKey('sk_test_co5CoSxhQlkaWtFYu8ytyPRE00v7PWGVhL');

        $intent = \Stripe\PaymentIntent::create([
            'amount' => $montantUSD * 100,
            'currency' => 'usd',
            // Verify your integration in this guide by including this parameter
            'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);


        //return new JsonResponse();
        return $this->render('@Velotn/Front/thankyousupport.html.twig',array(
            'cart'=>$cart,
            'wish'=>$wish
        ));
    }
}