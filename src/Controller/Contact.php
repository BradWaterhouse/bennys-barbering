<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Basket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class Contact extends AbstractController
{
    private Basket $basket;

    public function __construct(Basket $basket)
    {
        $this->basket = $basket;
    }

    /**
     * @Route("/contact", name="contact", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('Pages/contact.html.twig', [
            'showNav' => true,
            'basketTotal' => $this->basket->calculateTotal()
        ]);
    }
}
