<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Search;

use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class ProductGroupTest extends TestCase
{
    protected function setUp()
    {
        $this->productFactoryMock    = $this->createMock(
            AmazonFactory\Product::class
        );
        $this->productGroupTableMock = $this->createMock(
            AmazonTable\Search\ProductGroup::class
        );

        $this->searchProductGroupService = new AmazonService\Search\ProductGroup(
            $this->productFactoryMock,
            $this->productGroupTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\Search\ProductGroup::class,
            $this->searchProductGroupService
        );
    }
}
