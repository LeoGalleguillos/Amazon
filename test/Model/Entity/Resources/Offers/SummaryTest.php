<?php
namespace LeoGalleguillos\AmazonTest\Model\Entity\Resources\Offers;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use PHPUnit\Framework\TestCase;

class SummaryTest extends TestCase
{
    protected function setUp()
    {
        $this->summaryEntity = new AmazonEntity\Resources\Offers\Summary();
    }

    public function testGettersAndSetters()
    {
        $condition = 'New';
        $this->assertSame(
            $this->summaryEntity,
            $this->summaryEntity->setCondition($condition)
        );
        $this->assertSame(
            $condition,
            $this->summaryEntity->getCondition()
        );

        $highestPrice = 1.23;
        $this->assertSame(
            $this->summaryEntity,
            $this->summaryEntity->setHighestPrice($highestPrice)
        );
        $this->assertSame(
            $highestPrice,
            $this->summaryEntity->getHighestPrice()
        );

        $lowestPrice = 0.99;
        $this->assertSame(
            $this->summaryEntity,
            $this->summaryEntity->setLowestPrice($lowestPrice)
        );
        $this->assertSame(
            $lowestPrice,
            $this->summaryEntity->getLowestPrice()
        );

        $offerCount = 7;
        $this->assertSame(
            $this->summaryEntity,
            $this->summaryEntity->setOfferCount($offerCount)
        );
        $this->assertSame(
            $offerCount,
            $this->summaryEntity->getOfferCount()
        );
    }
}
