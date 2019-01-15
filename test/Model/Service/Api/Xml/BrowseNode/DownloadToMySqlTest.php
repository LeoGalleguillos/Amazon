<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Xml\BrowseNode;

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
        $this->downloadToMySqlService = new AmazonService\Api\Xml\BrowseNode\DownloadToMySql(
            $this->browseNodeTableMock,
            $this->browseNodeProductTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\Api\Xml\BrowseNode\DownloadToMySql::class,
            $this->downloadToMySqlService
        );
    }

    public function testDownloadToMySql()
    {
        $xml = simplexml_load_file($_SERVER['PWD'] . '/test/data/api/xml/browse-node.xml');

        $this->browseNodeTableMock
            ->expects($this->once())
            ->method('insertIgnore')
            ->with(7581669011, 'Shops');
        $this->browseNodeProductTableMock
            ->expects($this->once())
            ->method('insertIgnore')
            ->with(7581669011, 12345);

        $this->assertNull(
            $this->downloadToMySqlService->downloadToMySql(
                12345,
                $xml
            )
        );
    }
}
