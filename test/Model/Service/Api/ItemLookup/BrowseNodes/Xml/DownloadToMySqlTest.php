<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\ItemLookup\BrowseNodes;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class DownloadToMySqlTest extends TestCase
{
    protected function setUp()
    {
        $this->downloadToMySqlServiceMock = $this->createMock(
            AmazonService\Api\Xml\BrowseNode\DownloadToMySql::class
        );
        $this->browseNodeProductTableMock = $this->createMock(
            AmazonTable\BrowseNodeProduct::class
        );
        $this->asinTableMock = $this->createMock(
            AmazonTable\Product\Asin::class
        );
        $this->downloadToMySqlService = new AmazonService\Api\ItemLookup\BrowseNodes\Xml\DownloadToMySql(
            $this->downloadToMySqlServiceMock,
            $this->browseNodeProductTableMock,
            $this->asinTableMock
        );
    }

    public function testDownloadToMySql()
    {
        $xml = simplexml_load_file($_SERVER['PWD'] . '/test/data/api/item-lookup/browse-nodes/B0751FL325.xml');

        $this->assertTrue(
            $this->downloadToMySqlService->downloadToMySql($xml)
        );
    }
}
