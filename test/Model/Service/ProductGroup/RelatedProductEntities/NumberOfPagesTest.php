<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\ProductGroup\RelatedProductEntities;

use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class NumberOfPagesTest extends TestCase
{
    protected function setUp(): void
    {
        $this->modifiedTitleServiceMock = $this->createMock(
            AmazonService\Product\ModifiedTitle::class
        );
        $this->productGroupTableMock = $this->createMock(
            AmazonTable\Search\ProductGroup::class
        );

        $this->numberOfPagesService = new AmazonService\ProductGroup\RelatedProductEntities\NumberOfPages(
            $this->modifiedTitleServiceMock,
            $this->productGroupTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\ProductGroup\RelatedProductEntities\NumberOfPages::class,
            $this->numberOfPagesService
        );
    }
}
