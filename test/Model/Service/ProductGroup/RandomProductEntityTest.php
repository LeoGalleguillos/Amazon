<?php
namespace LeoGalleguillos\AmazonTest\Model\Service;

use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class RandomProductEntityTest extends TestCase
{
    protected function setUp(): void
    {
        $this->productFactoryMock = $this->createMock(
            AmazonFactory\Product::class
        );
        $this->productIdTableMock = $this->createMock(
            AmazonTable\Product\ProductId::class
        );

        $this->randomProductEntityService = new AmazonService\ProductGroup\RandomProductEntity(
            $this->productFactoryMock,
            $this->productIdTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\ProductGroup\RandomProductEntity::class,
            $this->randomProductEntityService
        );
    }
}
