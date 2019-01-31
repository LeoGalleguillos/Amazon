<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;
use TypeError;

class BrowseNodeHierarchyTest extends TableTestCase
{
    protected function setUp()
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

    public function testSelectWhereBrowseNodeIdParent()
    {
        try {
            $this->browseNodeHierarchyTable->selectWhereBrowseNodeIdParent(27182);
            $this->fail();
        } catch (TypeError $typeError) {
            $this->assertSame(
                'Return value of',
                substr($typeError->getMessage(), 0, 15)
            );
        }

        $this->browseNodeHierarchyTable->insertIgnore(27182, 31415);

        $this->assertSame(
            [
                'browse_node_id_parent' => '27182',
                'browse_node_id_child'  => '31415',
            ],
            $this->browseNodeHierarchyTable->selectWhereBrowseNodeIdParent(27182)
        );
    }
}
