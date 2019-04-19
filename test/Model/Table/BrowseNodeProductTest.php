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

    public function testInsertIgnore()
    {
        $this->assertSame(
            1,
            $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(1, 1, 1)
        );
        $this->assertSame(
            2,
            $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(1, 1, 2)
        );
        $this->assertSame(
            1,
            $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(2, 1, 1)
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

    public function testSelectWhereProductId()
    {
        $this->assertSame(
            [],
            iterator_to_array($this->browseNodeProductTable->selectWhereProductId(12345))
        );

        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(948, 12345, 1);
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(12345, 38576, 1);
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(11, 12345, 1);

        $this->assertSame(
            [
                0 => [
                    'browse_node_id' => '11',
                    'product_id' => '12345',
                ],
                1 => [
                    'browse_node_id' => '948',
                    'product_id' => '12345',
                ],
            ],
            iterator_to_array($this->browseNodeProductTable->selectWhereProductId(12345))
        );
    }
}
