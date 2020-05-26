<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;
use TypeError;

class BrowseNodeHierarchyTest extends TableTestCase
{
    protected function setUp(): void
    {
        $this->browseNodeHierarchyTable = new AmazonTable\BrowseNodeHierarchy(
            $this->getAdapter()
        );

        $this->dropTable('browse_node_hierarchy');
        $this->createTable('browse_node_hierarchy');
    }

    public function testInsertIgnore()
    {
        $this->assertSame(
            1,
            $this->browseNodeHierarchyTable->insertIgnore(12345, 67890)
        );
        $this->assertSame(
            0,
            $this->browseNodeHierarchyTable->insertIgnore(12345, 67890)
        );
        $this->assertSame(
            1,
            $this->browseNodeHierarchyTable->insertIgnore(31415, 27182)
        );
    }

    public function testSelectWhereBrowseNodeIdChild()
    {
        $generator = $this->browseNodeHierarchyTable->selectWhereBrowseNodeIdChild(27182);
        $this->assertSame(
            [],
            iterator_to_array($generator)
        );

        $this->browseNodeHierarchyTable->insertIgnore(27182, 31415);
        $this->browseNodeHierarchyTable->insertIgnore(93857, 9475);
        $this->browseNodeHierarchyTable->insertIgnore(27182, 9475);
        $this->browseNodeHierarchyTable->insertIgnore(27182, 99928);

        $generator = $this->browseNodeHierarchyTable->selectWhereBrowseNodeIdChild(9475);

        $this->assertSame(
            [
                0 => [
                    'browse_node_id_parent' => '27182',
                    'browse_node_id_child'  => '9475',
                ],
                1 => [
                    'browse_node_id_parent' => '93857',
                    'browse_node_id_child'  => '9475',
                ],
            ],
            iterator_to_array($generator)
        );
    }

    public function testSelectWhereBrowseNodeIdParent()
    {
        $generator = $this->browseNodeHierarchyTable->selectWhereBrowseNodeIdParent(27182);
        $this->assertSame(
            [],
            iterator_to_array($generator)
        );

        $this->browseNodeHierarchyTable->insertIgnore(27182, 31415);
        $this->browseNodeHierarchyTable->insertIgnore(93857, 9475);
        $this->browseNodeHierarchyTable->insertIgnore(27182, 9475);
        $this->browseNodeHierarchyTable->insertIgnore(27182, 99928);

        $generator = $this->browseNodeHierarchyTable->selectWhereBrowseNodeIdParent(27182);

        $this->assertSame(
            [
                0 => [
                    'browse_node_id_parent' => '27182',
                    'browse_node_id_child'  => '9475',
                ],
                1 => [
                    'browse_node_id_parent' => '27182',
                    'browse_node_id_child'  => '31415',
                ],
                2 => [
                    'browse_node_id_parent' => '27182',
                    'browse_node_id_child'  => '99928',
                ],
            ],
            iterator_to_array($generator)
        );
    }
}
