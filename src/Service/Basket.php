<?php

declare(strict_types=1);

namespace App\Service;

use Money\Money;
use Money\MoneyFormatter;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Basket
{
    private SessionInterface $session;
    private MoneyFormatter $money;

    public function __construct(SessionInterface $session, MoneyFormatter $money)
    {
        $this->session = $session;
        $this->money = $money;
    }

    public function calculateTotal(): string
    {
        if ($this->session->get('quantity')) {
            $quantity = $this->session->get('quantity');

            $pricePerUnit = Money::GBP(1099);
            $pricePerUnit = $pricePerUnit->multiply($quantity);

            return $this->money->format($pricePerUnit);
        }

        return '0.00';
    }
}
