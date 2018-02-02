<?php
namespace LeoGalleguillos\AmazonTest\Model\Service;

use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class BrandTest extends TestCase
{
    protected function setUp()
    {
        $this->productFactoryMock = $this->createMock(AmazonFactory\Product::class);
        $this->brandTableMock     = $this->createMock(AmazonTable\Brand::class);

        $this->brandService = new AmazonService\Brand(
            $this->productFactoryMock,
            $this->brandTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\Brand::class,
            $this->brandService
        );
    }
}
