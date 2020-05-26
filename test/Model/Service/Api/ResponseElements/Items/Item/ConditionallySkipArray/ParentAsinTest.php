<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\ResponseElements\Items\Item\ConditionallySkipArray;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class ParentAsinTest extends TestCase
{
    protected function setUp(): void
    {
        $this->parentAsinService = new AmazonService\Api\ResponseElements\Items\Item\ConditionallySkipArray\ParentAsin();
    }

    public function test_shouldArrayBeSkipped_emptyArray_false()
    {
        $this->assertFalse(
            $this->parentAsinService->shouldArrayBeSkipped(
                []
            )
        );
    }

    public function test_shouldArrayBeSkipped_noParentAsin_false()
    {
        $this->assertFalse(
            $this->parentAsinService->shouldArrayBeSkipped(
                [
                    'ASIN' => 'B074JF7M9X',
                ]
            )
        );
    }

    public function test_shouldArrayBeSkipped_parentAsinExists_true()
    {
        $this->assertTrue(
            $this->parentAsinService->shouldArrayBeSkipped(
                [
                    'ASIN' => 'B07XQXZXJC',
                    'ParentASIN' => 'B01GY35T4S',
                ]
            )
        );
    }
}
