<?php
namespace LeoGalleguillos\AmazonTest\Model\Service;

use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class ProductGroupTest extends TestCase
{
    protected function setUp(): void
    {
        $this->productFactoryMock    = $this->createMock(AmazonFactory\Product::class);
        $this->productGroupTableMock = $this->createMock(AmazonTable\ProductGroup::class);

        $this->productGroupService = new AmazonService\ProductGroup(
            $this->productFactoryMock,
            $this->productGroupTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(AmazonService\ProductGroup::class, $this->productGroupService);
    }
}
