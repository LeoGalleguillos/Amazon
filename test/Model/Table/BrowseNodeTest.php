<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;

class BrowseNodeTest extends TableTestCase
{
    protected function setUp()
    {
        $this->browseNodeTable = new AmazonTable\BrowseNode(
            $this->getAdapter()
        );

        $this->dropTable('browse_node');
        $this->createTable('browse_node');
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonTable\BrowseNode::class,
            $this->browseNodeTable
        );
    }

    public function testInsertIgnore()
    {
        $this->assertSame(
            1,
            $this->browseNodeTable->insertIgnore(1, 'name')
        );
        $this->assertSame(
            0,
            $this->browseNodeTable->insertIgnore(1, 'name')
        );
        $this->assertSame(
            1,
            $this->browseNodeTable->insertIgnore(5, 'name')
        );
    }
}
