<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;

class BrowseNodeProductTest extends TableTestCase
{
    protected function setUp()
    {
        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTables(['browse_node', 'browse_node_product', 'product']);
        $this->setForeignKeyChecks(1);

        $this->browseNodeTable = new AmazonTable\BrowseNode(
            $this->getAdapter()
        );
        $this->productTable = new AmazonTable\Product(
            $this->getAdapter()
        );
        $this->browseNodeProductTable = new AmazonTable\BrowseNodeProduct(
            $this->getAdapter()
        );
    }

    public function testInsertIgnore()
    {
        $this->browseNodeTable->insertIgnore(
            1,
            'Browse Node Name 1'
        );
        $this->browseNodeTable->insertIgnore(
            2,
            'Browse Node Name 2'
        );
        $this->productTable->insert(
            'ASIN',
            'Title',
            'Product Group',
            'Binding',
            'Brand',
            3.14
        );

        $this->assertSame(
            1,
            $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(1, 1, 1, 1)
        );
        $this->assertSame(
            2,
            $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(1, 1, 2, 2)
        );
        $this->assertSame(
            1,
            $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(2, 1, 123, 1)
        );
        $this->assertSame(
            0,
            $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(2, 1, 123, 1)
        );
        $this->assertSame(
            2,
            $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(2, 1, null, 10)
        );
    }

    public function test_selectCountWhereBrowseNodeId_variousRows_expectedCount()
    {
        $this->setForeignKeyChecks(0);
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(1, 10, null, 1);
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(1, 20, null, 1);
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(3, 10, null, 2);
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(1, 10, null, 1);

        $result = $this->browseNodeProductTable->selectCountWhereBrowseNodeId(1);
        $this->assertSame(
            '2',
            $result->current()['COUNT(*)']
        );

        $result = $this->browseNodeProductTable->selectCountWhereBrowseNodeId(2);
        $this->assertSame(
            '0',
            $result->current()['COUNT(*)']
        );

        $result = $this->browseNodeProductTable->selectCountWhereBrowseNodeId(3);
        $this->assertSame(
            '1',
            $result->current()['COUNT(*)']
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

        $this->browseNodeTable->insertIgnore(
            948,
            'awesome'
        );
        $this->browseNodeTable->insertIgnore(
            12345,
            'super'
        );
        $this->browseNodeTable->insertIgnore(
            11,
            'cool'
        );
        $this->productTable->insert(
            'ASIN',
            'Title',
            'Product Group',
            'Binding',
            'Brand',
            3.14
        );
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(948, 1, null, 2);
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(12345, 38576, 123, 1);
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(11, 1, 123, 1);

        $this->assertSame(
            [
                0 => [
                    'browse_node_id' => '11',
                    'product_id'     => '1',
                    'sales_rank'     => '123',
                    'order'          => '1',
                ],
                1 => [
                    'browse_node_id' => '948',
                    'product_id'     => '1',
                    'sales_rank'     => null,
                    'order'          => '2',
                ],
            ],
            iterator_to_array($this->browseNodeProductTable->selectWhereProductId(1))
        );
    }

    public function test_selectProductIdWhereBrowseNodeIdLimit_multipleRows_multipleResults()
    {
        $this->setForeignKeyChecks(0);
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(1, 10, null, 1);
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(3, 10, null, 2);
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(1, 20, null, 1);
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(3, 30, null, 1);
        $result = $this->browseNodeProductTable
            ->selectProductIdWhereBrowseNodeIdLimit(
                1,
                0,
                100
            );
        $this->assertSame(
            [
                ['product_id' => '20'],
                ['product_id' => '10'],
            ],
            iterator_to_array($result)
        );
    }
}
