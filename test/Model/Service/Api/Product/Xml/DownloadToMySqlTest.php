<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Product;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class DownloadToMySqlTest extends TestCase
{
    protected function setUp()
    {
        $this->productTableMock = $this->createMock(AmazonTable\Product::class);
        $this->productFeatureTableMock = $this->createMock(AmazonTable\ProductFeature::class);
        $this->productImageTableMock = $this->createMock(AmazonTable\ProductImage::class);
        $this->downloadToMySqlService = new AmazonService\Api\Product\Xml\DownloadToMySql(
            $this->productTableMock,
            $this->productFeatureTableMock,
            $this->productImageTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\Api\Product\Xml\DownloadToMySql::class,
            $this->downloadToMySqlService
        );
    }

    public function testDownloadToMySql()
    {
        $null = $this->downloadToMySqlService->downloadToMySql(
            simplexml_load_file($_SERVER['PWD'] . '/test/B0070UXDHU.xml')
        );
        $this->assertNull(
            $null
        );
    }
}
