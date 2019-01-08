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

    public function testSelectWhereName()
    {
        $generator = $this->browseNodeTable->selectWhereName('Name');
        $this->assertSame(
            [],
            iterator_to_array($generator)
        );

        $this->browseNodeTable->insertIgnore(98, 'Foo');
        $this->browseNodeTable->insertIgnore(35791, 'Bar');
        $this->browseNodeTable->insertIgnore(2468, 'Foo');

        $generator = $this->browseNodeTable->selectWhereName('Foo');
        $this->assertSame(
            [
                [
                    'browse_node_id' => '98',
                    'name' => 'Foo'
                ],
                [
                    'browse_node_id' => '2468',
                    'name' => 'Foo'
                ],
            ],
            iterator_to_array($generator)
        );
    }
}
