<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;

class BrowseNodeProductTest extends TableTestCase
{
    protected function setUp()
    {
        $this->browseNodeProductTable = new AmazonTable\BrowseNodeProduct(
            $this->getAdapter()
        );

        $this->dropTable('browse_node_product');
        $this->createTable('browse_node_product');
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonTable\BrowseNodeProduct::class,
            $this->browseNodeProductTable
        );
    }

    public function testInsertIgnore()
    {
        $this->assertSame(
            1,
            $this->browseNodeProductTable->insertIgnore(1, 1)
        );
        $this->assertSame(
            0,
            $this->browseNodeProductTable->insertIgnore(1, 1)
        );
        $this->assertSame(
            1,
            $this->browseNodeProductTable->insertIgnore(2, 1)
        );
    }

    public function testSelectProductIdWhereSimilarRetrievedIsNullAndBrowseNodeId()
    {
        $productId = $this->browseNodeProductTable->selectProductIdWhereSimilarRetrievedIsNullAndBrowseNodeId(
            12345
        );
        $this->assertSame(
            0,
            $productId
        );
    }

    public function testSelectProductIdWhereVideoGeneratedIsNullAndBrowseNodeId()
    {
        $productId = $this->browseNodeProductTable->selectProductIdWhereVideoGeneratedIsNullAndBrowseNodeId(
            12345
        );
        $this->assertSame(
            0,
            $productId
        );
    }
}
