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
        $this->browseNodeTableMock = $this->createMock(
            AmazonTable\BrowseNode::class
        );
        $this->browseNodeProductTableMock = $this->createMock(
            AmazonTable\BrowseNodeProduct::class
        );
        $this->asinTableMock = $this->createMock(
            AmazonTable\Product\Asin::class
        );
        $this->downloadToMySqlService = new AmazonService\Api\ItemLookup\BrowseNodes\Xml\DownloadToMySql(
            $this->browseNodeTableMock,
            $this->browseNodeProductTableMock,
            $this->asinTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\Api\ItemLookup\BrowseNodes\Xml\DownloadToMySql::class,
            $this->downloadToMySqlService
        );
    }

    public function testDownloadToMySql()
    {
        $xml = simplexml_load_file($_SERVER['PWD'] . '/test/data/api/item-lookup/browse-nodes/B0751FL325.xml');

        $this->assertNull(
            $this->downloadToMySqlService->downloadToMySql($xml)
        );
    }
}
