<?php
namespace LeoGalleguillos\AmazonTest\Model\Factory\Resources\Offers;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use PHPUnit\Framework\TestCase;

class SummaryTest extends TestCase
{
    protected function setUp(): void
    {
        $this->summaryFactory = new AmazonFactory\Resources\Offers\Summary();
    }

    public function test_buildFromArray_arrayWithAllKeys_object()
    {
        $array = [
            'condition'     => 'New',
            'highest_price' => '100.00',
            'lowest_price'  => '0.01',
            'offer_count'   => '123',
        ];
        $summaryEntity = new AmazonEntity\Resources\Offers\Summary();
        $summaryEntity
            ->setCondition($array['condition'])
            ->setHighestPrice($array['highest_price'])
            ->setLowestPrice($array['lowest_price'])
            ->setOfferCount((int) $array['offer_count'])
            ;
        $this->assertEquals(
            $summaryEntity,
            $this->summaryFactory->buildFromArray($array)
        );
    }

    public function test_buildFromArray_arrayWithSomeKeys_object()
    {
        $array = [
            'condition'     => 'Collectible',
            'offer_count'   => '45678',
        ];
        $summaryEntity = new AmazonEntity\Resources\Offers\Summary();
        $summaryEntity
            ->setCondition($array['condition'])
            ->setOfferCount((int) $array['offer_count'])
            ;
        $this->assertEquals(
            $summaryEntity,
            $this->summaryFactory->buildFromArray($array)
        );
    }
}
