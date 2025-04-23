<?php

namespace App\Service;

use App\Entity\PriceRecord;
use Doctrine\ORM\EntityManagerInterface;

class PriceRecordService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function savePriceRecord(
        float $goldPriceUsd,
        float $goldPriceCzk,
        float $microsoftPriceUsd,
        float $microsoftPriceCzk
    ): void {
        $priceRecord = new PriceRecord();
        $priceRecord->setRecordedAt(new \DateTime());
        $priceRecord->setGoldPriceUsd($goldPriceUsd);
        $priceRecord->setGoldPriceCzk($goldPriceCzk);
        $priceRecord->setMicrosoftPriceUsd($microsoftPriceUsd);
        $priceRecord->setMicrosoftPriceCzk($microsoftPriceCzk);

        $this->entityManager->persist($priceRecord);
        $this->entityManager->flush();
    }
}