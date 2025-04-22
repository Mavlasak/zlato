<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoldPriceService
{
    private HttpClientInterface $client;
    private string $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function getGoldPrice(): ?array
    {
        $response = $this->client->request('GET', 'https://api.api-ninjas.com/v1/commodityprice?name=gold', [
            'headers' => [
                'X-Api-Key' => $this->apiKey,
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