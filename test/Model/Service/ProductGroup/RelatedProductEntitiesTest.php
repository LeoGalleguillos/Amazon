<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\ProductGroup;

use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class RelatedProductEntitiesTest extends TestCase
{
    protected function setUp(): void
    {
        $this->productFactoryMock = $this->createMock(
            AmazonFactory\Product::class
        );
        $this->modifiedTitleServiceMock = $this->createMock(
            AmazonService\Product\ModifiedTitle::class
        );
        $this->productGroupTableMock = $this->createMock(
            AmazonTable\Search\ProductGroup::class
        );

        $this->relatedProductEntitiesService = new AmazonService\ProductGroup\RelatedProductEntities(
            $this->productFactoryMock,
            $this->modifiedTitleServiceMock,
            $this->productGroupTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\ProductGroup\RelatedProductEntities::class,
            $this->relatedProductEntitiesService
        );
    }
}
