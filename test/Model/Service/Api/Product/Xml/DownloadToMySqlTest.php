<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Product;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class DownloadToMySqlTest extends TestCase
{
    protected function setUp(): void
    {
        $this->downloadToMySqlServiceMock = $this->createMock(
            AmazonService\Api\Xml\BrowseNode\DownloadToMySql::class
        );
        $this->browseNodeProductTableMock = $this->createMock(AmazonTable\BrowseNodeProduct::class);
        $this->productTableMock = $this->createMock(AmazonTable\Product::class);
        $this->productFeatureTableMock = $this->createMock(AmazonTable\ProductFeature::class);
        $this->productImageTableMock = $this->createMock(AmazonTable\ProductImage::class);

        $this->downloadToMySqlService = new AmazonService\Api\Product\Xml\DownloadToMySql(
            $this->downloadToMySqlServiceMock,
            $this->browseNodeProductTableMock,
            $this->productTableMock,
            $this->productFeatureTableMock,
            $this->productImageTableMock
        );
    }

    public function testDownloadToMySql()
    {
        $this->productTableMock->method('insert')->willReturn(12345);

        $this->downloadToMySqlServiceMock
            ->expects($this->exactly(2))
            ->method('downloadToMySql');

        $this->browseNodeProductTableMock
            ->expects($this->exactly(2))
            ->method('insertOnDuplicateKeyUpdate')
            ->withConsecutive(
                [14333511, 12345, null, 1],
                [7581668011, 12345, null, 2]
            );

        $this->downloadToMySqlService->downloadToMySql(
            simplexml_load_file($_SERVER['PWD'] . '/test/B0070UXDHU.xml')
        );
    }
}
