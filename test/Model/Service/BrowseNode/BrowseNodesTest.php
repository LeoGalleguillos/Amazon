<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\BrowseNode;

use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class BrowseNodesTest extends TestCase
{
    protected function setUp()
    {
        $this->browseNodeFactoryMock = $this->createMock(
            AmazonFactory\BrowseNode::class
        );
        $this->browseNodeTableMock = $this->createMock(
            AmazonTable\BrowseNode::class
        );

        $this->browseNodesService = new AmazonService\BrowseNode\BrowseNodes(
            $this->browseNodeFactoryMock,
            $this->browseNodeTableMock
        );

        $this->browseNode1 = new AmazonEntity\BrowseNode();
        $this->browseNode2 = new AmazonEntity\BrowseNode();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\BrowseNode\BrowseNodes::class,
            $this->browseNodesService
        );
    }

    public function testGetBrowseNodes()
    {
        $this->browseNodeTableMock->method('selectWhereName')->will(
            $this->onConsecutiveCalls(
                $this->returnEmptyGenerator(),
                $this->yieldTwoArrays()
            )
        );

        $generator = $this->browseNodesService->getBrowseNodes('Name');
        $this->assertSame(
            [],
            iterator_to_array($generator)
        );

        $this->browseNodeFactoryMock->method('buildFromArray')->will(
            $this->onConsecutiveCalls(
                $this->browseNode1,
                $this->browseNode2
            )
        );
        $generator = $this->browseNodesService->getBrowseNodes('Name');
        $this->assertSame(
            [
                $this->browseNode1,
                $this->browseNode2,
            ],
            iterator_to_array($generator)
        );
    }

    protected function returnEmptyGenerator(): Generator
    {
        yield from [];
    }

    protected function yieldTwoArrays(): Generator
    {
        yield [];
        yield [];
    }
}
