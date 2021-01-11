<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderValidateController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/commande/merci/{stripeSessionId}", name="order_validate")
     */
    public function index(Cart $cart, $stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::Class)->findOneByStripeSessionId($stripeSessionId);

        if(!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('home');
        }

        if (!$order->getIsPaid()){
            $cart->remove();
            $order->setIsPaid(1);
            $this->entityManager->flush();
        }

        $mail = new Mail();
                $content = 'Bonjour'.$order->getUser()->getFirstname().'<br>Merci pour votre commande <br> Bienvenue sur la premiere boutique dédiée au made in france';
                $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Votre commande la boutique française est bien validée', $content);
    


        return $this->render('order_validate/index.html.twig', [
            'order' => $order
        ]);
    }
}
