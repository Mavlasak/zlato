<?php

namespace App\Controller;

use App\Service\GoldPriceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GoldPriceController extends AbstractController
{
    #[Route('/gold-price', name: 'gold_price')]
    public function index(GoldPriceService $goldPriceService): Response
    {
        $goldData = $goldPriceService->getGoldPrice();

        if ($goldData === null) {
            return new Response('Nepodařilo se načíst cenu zlata.', 500);
        }

        return $this->render('gold_price/index.html.twig', [
            'price' => $goldData['price'],
            'time' => $goldData['time'],
        ]);
    }
}