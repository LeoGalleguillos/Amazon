<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;

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
}
