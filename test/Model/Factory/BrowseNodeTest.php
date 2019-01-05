<?php
namespace LeoGalleguillos\AmazonTest\Model\Factory;

use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Image\Model\Factory as ImageFactory;
use PHPUnit\Framework\TestCase;

class BrowseNodeTest extends TestCase
{
    protected function setUp()
    {
        $this->browseNodeTableMock = $this->createMock(
            AmazonTable\BrowseNode::class
        );

        $this->browseNodeFactory = new AmazonFactory\BrowseNode(
            $this->browseNodeTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonFactory\BrowseNode::class,
            $this->browseNodeFactory
        );
    }

    public function testBuildFromArray()
    {
        $array = [
            'browse_node_id' => '12345',
            'name'           => 'Name',
        ];
        $browseNodeEntity = $this->browseNodeFactory->buildFromArray($array);

        $this->assertSame(
            12345,
            $browseNodeEntity->getBrowseNodeId()
        );
        $this->assertSame(
            'Name',
            $browseNodeEntity->getName()
        );
    }
}
