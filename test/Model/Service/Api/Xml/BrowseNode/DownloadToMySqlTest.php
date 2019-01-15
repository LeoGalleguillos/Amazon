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
        $this->downloadToMySqlService = new AmazonService\Api\Xml\BrowseNode\DownloadToMySql(
            $this->browseNodeTableMock
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
            ->expects($this->exactly(5))
            ->method('insertIgnore')
            ->withConsecutive(
                [7581669011, 'Shops'],
                [11307730011, 'Contemporary & Designer'],
                [7581681011, 'Big & Tall'],
                [7581682011, 'Uniforms, Work & Safety'],
                [9564525011, 'Surf, Skate & Street']
            );

        $this->assertNull(
            $this->downloadToMySqlService->downloadToMySql(
                $xml
            )
        );
    }
}
