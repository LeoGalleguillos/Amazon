<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class SimilarProductsTest extends TestCase
{
    protected function setUp(): void
    {
        $this->productFactoryMock = $this->createMock(
            AmazonFactory\Product::class
        );
        $this->apiServiceMock = $this->createMock(
            AmazonService\Api::class
        );
        $this->downloadToMySqlServiceMock = $this->createMock(
            AmazonService\Api\Product\Xml\DownloadToMySql::class
        );
        $this->apiSimilarProductsXmlServiceMock = $this->createMock(
            AmazonService\Api\SimilarProducts\Xml::class
        );
        $this->productServiceMock = $this->createMock(
            AmazonService\Product::class
        );
        $this->productTableMock = $this->createMock(
            AmazonTable\Product::class
        );
        $this->productSimilarTableMock = $this->createMock(
            AmazonTable\Product\Similar::class
        );
        $this->productSimilarRetrievedTableMock = $this->createMock(
            AmazonTable\Product\SimilarRetrieved::class
        );

        $this->similarProductsService = new AmazonService\Product\SimilarProducts(
            $this->productFactoryMock,
            $this->apiServiceMock,
            $this->downloadToMySqlServiceMock,
            $this->apiSimilarProductsXmlServiceMock,
            $this->productServiceMock,
            $this->productTableMock,
            $this->productSimilarTableMock,
            $this->productSimilarRetrievedTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\Product\SimilarProducts::class,
            $this->similarProductsService
        );
    }

    public function testGetSimilarProducts()
    {
        $asin = '';
        $this->assertEmpty(
            $this->similarProductsService->getSimilarProducts($asin)
        );

        $this->productSimilarTableMock->method('getSimilarAsins')->will(
            $this->onConsecutiveCalls(
                [1, 2, 3],
                [1, 2, 3]
            )
        );
        $this->assertSame(
            3,
            count($this->similarProductsService->getSimilarProducts($asin))
        );
    }
}
