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

    public function testSelectProductIdWhereSimilarRetrievedIsNullAndBrowseNodeIdLimit1()
    {
        $productId = $this->browseNodeProductTable->selectProductIdWhereSimilarRetrievedIsNullAndBrowseNodeIdLimit1(
            12345
        );
        $this->assertSame(
            0,
            $productId
        );
    }

    public function testSelectProductIdWhereSimilarRetrievedIsNullAndBrowseNodeIdInLimit1()
    {
        $productId = $this->browseNodeProductTable->selectProductIdWhereSimilarRetrievedIsNullAndBrowseNodeIdInLimit1(
            [1, 2, 3, 4, 5]
        );
        $this->assertSame(
            0,
            $productId
        );
    }

    public function testSelectProductIdWhereVideoGeneratedIsNullAndBrowseNodeIdInLimit1()
    {
        $productId = $this->browseNodeProductTable->selectProductIdWhereVideoGeneratedIsNullAndBrowseNodeIdInLimit1(
            [1, 2, 3, 4, 5]
        );
        $this->assertSame(
            0,
            $productId
        );
    }

    public function testSelectProductIdWhereVideoGeneratedIsNullAndBrowseNodeIdLimit1()
    {
        $productId = $this->browseNodeProductTable->selectProductIdWhereVideoGeneratedIsNullAndBrowseNodeIdLimit1(
            12345
        );
        $this->assertSame(
            0,
            $productId
        );
    }
}
