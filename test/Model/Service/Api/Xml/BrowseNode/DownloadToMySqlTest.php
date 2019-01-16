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
        $this->browseNodeHierarchyTableMock = $this->createMock(
            AmazonTable\BrowseNodeHierarchy::class
        );
        $this->downloadToMySqlService = new AmazonService\Api\Xml\BrowseNode\DownloadToMySql(
            $this->browseNodeTableMock,
            $this->browseNodeHierarchyTableMock
        );
    }

    public function testDownloadToMySql()
    {
        $xml = simplexml_load_file($_SERVER['PWD'] . '/test/data/api/xml/browse-node.xml');

        $this->browseNodeTableMock
            ->expects($this->exactly(8))
            ->method('insertIgnore')
            ->withConsecutive(
                [7581669011, 'Shops'],
                [11307730011, 'Contemporary & Designer'],
                [7581681011, 'Big & Tall'],
                [7581682011, 'Uniforms, Work & Safety'],
                [9564525011, 'Surf, Skate & Street'],
                [7147441011, 'Men'],
                [7141124011, 'Departments'],
                [7141123011, 'Clothing, Shoes & Jewelry']
            );

        $this->browseNodeHierarchyTableMock
            ->expects($this->exactly(7))
            ->method('insertIgnore')
            ->withConsecutive(
                [7581669011, 11307730011],
                [7581669011, 7581681011],
                [7581669011, 7581682011],
                [7581669011, 9564525011],
                [7147441011, 7581669011],
                [7141124011, 7147441011],
                [7141123011, 7141124011]
            );

        $this->assertNull(
            $this->downloadToMySqlService->downloadToMySql(
                $xml
            )
        );
    }
}
