<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class StockPriceService
{
    private HttpClientInterface $client;
    private string $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function getStockPrice(string $symbol): ?array
    {
        $response = $this->client->request('GET', 'https://api.api-ninjas.com/v1/stockprice', [
            'headers' => [
                'X-Api-Key' => $this->apiKey,
            ],
            'query' => [
                'ticker' => $symbol,
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            return null;
        }

        $data = $response->toArray();

        $timezone = new \DateTimeZone('Europe/Prague');
        $updatedTime = isset($data['updated'])
            ? (new \DateTime())->setTimestamp($data['updated'])->setTimezone($timezone)->format('Y-m-d H:i:s')
            : null;

        return [
            'price' => $data['price'] ?? null,
            'time' => $updatedTime,
        ];
    }
}