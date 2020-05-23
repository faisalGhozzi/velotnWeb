<?php

namespace VelotnBundle\Controller;

use ClassesWithParents\D;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use VelotnBundle\Form\DonType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        /*$don->setDateDon(new DateTime('now'));
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($don);
            $em->flush();
            return $this->redirectToRoute('index');
        }*/

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $cart = $em->getRepository('VelotnBundle:Panier')->findByUser($user);
        $wish = $em->getRepository('VelotnBundle:Wishlist')->findByUser($user);
        /*$ids=array();
        foreach ($cart as $item)
        {
            array_push($ids,($item->getProduit()->getId()));
        }*/

        return $this->render('@Velotn/Front/don.html.twig', array(
            'form' => $form->createView(),
            'cart' => $cart,
            'wish' => $wish
        ));
    }
    /**
     * @Route("/admin/afficherDons",name="affichagedons")
     */
    public function afficherDonsAction(){
        $dons = $this->getDoctrine()->getRepository(Don::class)->findAll() ;
        return $this->render('@Velotn/Back/Don/afficherDons.html.twig', array(
            'dons'=>$dons
        ));
    }

    /**
     * @Route("/dons/",name="AfficherDonsJson")
     */
    public function afficherDonsJsonAction(){
        $dons = $this->getDoctrine()->getRepository(Don::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $dateSerializer = new Serializer([new DateTimeNormalizer('d/m/Y')]);
        $json = array();
        foreach ($dons as $d){
            $temp = array(
                "id"=>$d->getId(),
                "somme"=>$d->getSomme(),
                "date"=>$dateSerializer->normalize($d->getDateDon())
            );
            array_push($json,$temp);
        }
        $formatted = $serializer->normalize($json);
        return new JsonResponse($formatted);
    }

    /**
     * @Route("/dons/new",name="AjouterDonsJson")
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */

    public function ajouterDonJsonAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $don = new Don();
        $don->setSomme($request->get('somme'));
        $don->setDateDon(new DateTime($request->get('date')));
        $em->persist($don);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($don);
        return new JsonResponse($formatted);
    }

}
