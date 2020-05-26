<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\ItemInfo\TradeInInfo;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class SetTest extends TestCase
{
    protected function setUp(): void
    {
        $this->setService = new AmazonService\Api\Resources\ItemInfo\TradeInInfo\Set();
    }

    public function test_getSet_completeArray_1AndFloat()
    {
        $array = array (
          'IsEligibleForTradeIn' => true,
          'Price' =>
          array (
            'Amount' => 25,
            'Currency' => 'USD',
            'DisplayAmount' => '$25.00',
          ),
        );
        $this->assertSame(
            [
                'is_eligible_for_trade_in' => 1,
                'trade_in_price' => 25.0,
            ],
            $this->setService->getSet($array)
        );
    }

    public function test_getSet_completeArray_0AndNull()
    {
        $array = array (
          'IsEligibleForTradeIn' => false,
        );
        $this->assertSame(
            [
                'is_eligible_for_trade_in' => 0,
                'trade_in_price' => null,
            ],
            $this->setService->getSet($array)
        );
    }

    public function test_getSet_emptyArray_nullAndNull()
    {
        $array = array (
        );
        $this->assertSame(
            [
                'is_eligible_for_trade_in' => null,
                'trade_in_price' => null,
            ],
            $this->setService->getSet($array)
        );
    }
}
