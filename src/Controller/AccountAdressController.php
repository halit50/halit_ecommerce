<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Adress;
use App\Form\AdressType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountAdressController extends AbstractController
{
    /**
     * @Route("/compte/adresses", name="account_adress")
     */
    public function index(): Response
    {
        return $this->render('account/address.html.twig');
    }

    /**
     * @Route("/compte/ajouter-une-adresse", name="account_adress_add")
     */
    public function add(Cart $cart, Request $request): Response
    {
        $address = new Adress();
        $form= $this->createForm(AdressType::class,$address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $address->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();
            if ($cart->get()){
                return $this->redirectToRoute('order');

            } else{
            return $this->redirectToRoute('account_adress');}
        }

        return $this->render('account/adress_add.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/compte/modifier-une-adresse/{id}", name="account_adress_edit")
     */
    public function edit(Adress $address, Request $request, $id): Response
    {
        if (!$address || $address->getUser() != $this->getUser()){
            return $this->redirectToRoute('account_adress');
        }
        $form= $this->createForm(AdressType::class,$address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $address->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('account_adress');
        }

        return $this->render('account/adress_edit.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/compte/supprimer-une-adresse/{id}", name="account_adress_delete")
     */
    public function delete(Adress $address, $id): Response
    {
        if ($address && $address->getUser() == $this->getUser()){
            return $this->redirectToRoute('account_adress');
        }
        
            $em = $this->getDoctrine()->getManager();
            $em->remove($address);
            $em->flush();
            return $this->redirectToRoute('account_adress');
        }

        
    
}
