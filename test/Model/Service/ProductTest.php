<?php
namespace LeoGalleguillos\AmazonTest\Model\Service;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class ProductTest extends TestCase
{
    protected function setUp()
    {
        $this->productFactoryMock = $this->createMock(
            AmazonFactory\Product::class
        );
        $this->apiServiceMock = $this->createMock(
            AmazonService\Api::class
        );
        $this->apiProductXmlServiceMock = $this->createMock(
            AmazonService\Api\Product\Xml::class
        );
        $this->downloadToMySqlServiceMock = $this->createMock(
            AmazonService\Api\Product\Xml\DownloadToMySql::class
        );
        $this->productTableMock = $this->createMock(
            AmazonTable\Product::class
        );

        $this->productService = new AmazonService\Product(
            $this->productFactoryMock,
            $this->apiServiceMock,
            $this->apiProductXmlServiceMock,
            $this->downloadToMySqlServiceMock,
            $this->productTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\Product::class,
            $this->productService
        );
    }

    public function testGetProduct()
    {
        $this->productTableMock->method('isProductInTable')->willReturn(
            true
        );
        $this->productFactoryMock->method('buildFromAsin')->willReturn(
            new AmazonEntity\Product()
        );

        $this->assertInstanceOf(
            AmazonEntity\Product::class,
            $this->productService->getProduct('ABCDEFG')
        );
    }
}
