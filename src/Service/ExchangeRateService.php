<?php

namespace App\Service;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExchangeRateService
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getUsdToCzkRate(): ?float
    {
        $response = $this->client->request('GET', 'https://www.kurzy.cz/kurzy-men/aktualni/czk-usd/');

        if ($response->getStatusCode() !== 200) {
            return null;
        }

        $html = $response->getContent();
        $crawler = new Crawler($html);

        try {
            // Najdeme první `<br>` obsahující text "za 1 USD ="
            $rateText = $crawler->filter('b')->reduce(function (Crawler $node) {
                return str_contains($node->text(), '1 USD =');
            })->first()->text();

            // Extrahujeme číselnou hodnotu z textu
            preg_match('/1 USD = ([0-9.,]+)/', $rateText, $matches);

            if (!isset($matches[1])) {
                return null;
            }

            // Převod na float (nahrazení čárky tečkou)
            return (float) str_replace(',', '.', $matches[1]);
        } catch (\Exception $e) {
            return null;
        }
    }
}