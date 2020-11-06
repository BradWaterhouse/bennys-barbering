<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Basket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

final class Product extends AbstractController
{
    private SessionInterface $session;
    private Basket $basket;

    public function __construct(SessionInterface $session, Basket $basket)
    {
        $this->session = $session;
        $this->basket = $basket;
    }

    /**
     * @Route("/products", name="products", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('Pages/single_product.html.twig', [
            'showNav' => true,
            'basketTotal' => $this->basket->calculateTotal()
        ]);
    }

    /**
     * @Route("/add-to-cart", name="add-to-cart", methods={"POST"})
     */
    public function add(Request $request): Response
    {
        $quantity = $request->get('quantity');
        $token = $request->get('token') ?? '';


        if ($this->isCsrfTokenValid('add-form', $token)) {
            $this->addToSession((int) $quantity);

            $this->addFlash('success', 'Added to basket');

            return $this->redirect('/products');
        }
    }

    private function addToSession(int $quantity): void
    {
        if ($this->session->get('quantity')) {
            $existingQuantity = $this->session->get('quantity');

            $existingQuantity += $quantity;
            $this->session->set('quantity', $existingQuantity);
        } else {
            $this->session->set('quantity', $quantity);
        }
    }
}
