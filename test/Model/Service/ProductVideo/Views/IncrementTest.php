<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\ProductVideo\Views;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class IncrementTest extends TestCase
{
    protected function setUp(): void
    {
        $this->productVideoIdTableMock = $this->createMock(
            AmazonTable\ProductVideo\ProductVideoId::class
        );

        $this->incrementService = new AmazonService\ProductVideo\Views\Increment(
            $this->productVideoIdTableMock
        );
    }

    public function testIncrementViews()
    {
        $this->productVideoIdTableMock
            ->method('updateSetViewsToViewsPlusOneWhereProductVideoId')
            ->will(
                $this->onConsecutiveCalls(0, 1)
            );

        $productVideoEntity = new AmazonEntity\ProductVideo();
        $productVideoEntity->setProductVideoId(123);

        $this->assertFalse(
            $this->incrementService->incrementViews(
                $productVideoEntity
            )
        );

        $this->assertTrue(
            $this->incrementService->incrementViews(
                $productVideoEntity
            )
        );
    }
}
