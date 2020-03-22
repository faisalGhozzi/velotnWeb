<?php

namespace VelotnBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use VelotnBundle\Entity\FosUser;
use VelotnBundle\Form\UserType;

class RegisterController extends Controller
{
    /*public function registerAction(Request $request)
    {
        $user = new FosUser();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

        }
        return $this->render('@Velotn/Front/register.html.twig', array(
            'form' => $form->createView()
        ));
    }*/

}
