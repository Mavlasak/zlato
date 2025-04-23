<?php

namespace App\Entity;

use App\Repository\PriceRecordRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PriceRecordRepository::class)]
class PriceRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $recordedAt;

    #[ORM\Column(type: 'float')]
    private float $goldPriceUsd;

    #[ORM\Column(type: 'float')]
    private float $goldPriceCzk;

    #[ORM\Column(type: 'float')]
    private float $microsoftPriceUsd;

    #[ORM\Column(type: 'float')]
    private float $microsoftPriceCzk;

    public function getId(): ?int
    {
        return $id;
    }

    public function getRecordedAt(): \DateTime
    {
        return $this->recordedAt;
    }

    public function setRecordedAt(\DateTime $recordedAt): self
    {
        $this->recordedAt = $recordedAt;
        return $this;
    }

    public function getGoldPriceUsd(): float
    {
        return $this->goldPriceUsd;
    }

    public function setGoldPriceUsd(float $goldPriceUsd): self
    {
        $this->goldPriceUsd = $goldPriceUsd;
        return $this;
    }

    public function getGoldPriceCzk(): float
    {
        return $this->goldPriceCzk;
    }

    public function setGoldPriceCzk(float $goldPriceCzk): self
    {
        $this->goldPriceCzk = $goldPriceCzk;
        return $this;
    }

    public function getMicrosoftPriceUsd(): float
    {
        return $this->microsoftPriceUsd;
    }

    public function setMicrosoftPriceUsd(float $microsoftPriceUsd): self
    {
        $this->microsoftPriceUsd = $microsoftPriceUsd;
        return $this;
    }

    public function getMicrosoftPriceCzk(): float
    {
        return $this->microsoftPriceCzk;
    }

    public function setMicrosoftPriceCzk(float $microsoftPriceCzk): self
    {
        $this->microsoftPriceCzk = $microsoftPriceCzk;
        return $this;
    }
}