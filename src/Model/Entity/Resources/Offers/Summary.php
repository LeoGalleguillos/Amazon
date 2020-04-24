<?php
namespace LeoGalleguillos\Amazon\Model\Entity\Resources\Offers;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class Summary
{
    /**
     * @var string
     */
    protected $condition;

    /**
     * @var float
     */
    protected $highestPrice;

    /**
     * @var float
     */
    protected $lowestPrice;

    /**
     * @var int
     */
    protected $offerCount;

    public function getCondition(): string
    {
        return $this->condition;
    }

    public function getHighestPrice(): float
    {
        return $this->highestPrice;
    }

    public function getLowestPrice(): float
    {
        return $this->lowestPrice;
    }

    public function getOfferCount(): int
    {
        return $this->offerCount;
    }

    public function setCondition(string $condition): self
    {
        $this->condition = $condition;
        return $this;
    }

    public function setHighestPrice(float $highestPrice): self
    {
        $this->highestPrice = $highestPrice;
        return $this;
    }

    public function setLowestPrice(float $lowestPrice): self
    {
        $this->lowestPrice = $lowestPrice;
        return $this;
    }

    public function setOfferCount(int $offerCount): self
    {
        $this->offerCount = $offerCount;
        return $this;
    }
}
