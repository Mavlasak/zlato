<?php

namespace App\Controller;

use App\Entity\PriceRecord;
use App\Service\ExchangeRateService;
use App\Service\GoldPriceService;
use App\Service\StockPriceService;
use App\Service\PriceRecordService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PriceController extends AbstractController
{
    #[Route('/prices', name: 'prices')]
    public function index(
        GoldPriceService $goldPriceService,
        StockPriceService $stockPriceService,
        ExchangeRateService $exchangeRateService,
        PriceRecordService $priceRecordService
    ): Response {
        $goldData = $goldPriceService->getGoldPrice();
        $microsoftData = $stockPriceService->getStockPrice('MSFT');
        $usdToCzkRate = $exchangeRateService->getUsdToCzkRate();

        if ($goldData === null || $microsoftData === null || $usdToCzkRate === null) {
            return new Response('Nepodařilo se načíst data.', 500);
        }

        // Výpočet cen v CZK
        $goldPriceCzk = $goldData['price'] * $usdToCzkRate * 2414406.5938;
        $microsoftPriceCzk = $microsoftData['price'] * $usdToCzkRate * 14407530;

        // Uložení do databáze pomocí služby
        $priceRecordService->savePriceRecord(
            $goldData['price'] * 2414406.5938,
            $goldPriceCzk,
            $microsoftData['price'] * 14407530,
            $microsoftPriceCzk
        );

        return $this->render('prices/index.html.twig', [
            'gold_price' => $goldData['price'],
            'microsoft_price' => $microsoftData['price'],
            'microsoft_time' => $microsoftData['time'],
            'gold_time' => $goldData['time'],
            'usd_to_czk_rate' => $usdToCzkRate,
        ]);
    }
}