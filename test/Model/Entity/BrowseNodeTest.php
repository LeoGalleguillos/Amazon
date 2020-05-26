<?php
namespace LeoGalleguillos\AmazonTest\Model\Entity;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use PHPUnit\Framework\TestCase;

class BrowseNodeTest extends TestCase
{
    protected function setUp(): void
    {
        $this->browseNodeEntity = new AmazonEntity\BrowseNode();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonEntity\BrowseNode::class,
            $this->browseNodeEntity
        );
    }

    public function testGettersAndSetters()
    {
        $browseNodeId = 12345;
        $this->assertSame(
            $this->browseNodeEntity,
            $this->browseNodeEntity->setBrowseNodeId($browseNodeId)
        );
        $this->assertSame(
            $browseNodeId,
            $this->browseNodeEntity->getBrowseNodeId()
        );

        $name = 'Name';
        $this->assertSame(
            $this->browseNodeEntity,
            $this->browseNodeEntity->setName($name)
        );
        $this->assertSame(
            $name,
            $this->browseNodeEntity->getName()
        );
    }
}
