<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\Product;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase as TableTestCase;

class ProductIdTest extends TableTestCase
{
    protected function setUp()
    {
        $this->setForeignKeyChecks(0);
        $this->dropTable('product');
        $this->createTable('product');
        $this->setForeignKeyChecks(1);

        $this->productTable = new AmazonTable\Product(
            $this->getAdapter()
        );
        $this->productIdTable = new AmazonTable\Product\ProductId(
            $this->getAdapter(),
            $this->productTable
        );
    }

    public function test_selectWhereProductIdIn()
    {
        $generator = $this->productIdTable->selectWhereProductIdIn([1, 2, 3]);
        $this->assertEmpty(
            iterator_to_array($generator)
        );
    }

    public function test_updateSetModifiedToUtcTimestampWhereProductId()
    {
        $result = $this->productIdTable->updateSetModifiedToUtcTimestampWhereProductId(
            1
        );
        $this->assertSame(
            0,
            $result->getAffectedRows()
        );

        $this->productTable->insert(
            'ASIN001',
            'Title',
            'Product Group',
            null,
            null,
            4.99
        );
        $result = $this->productIdTable->updateSetModifiedToUtcTimestampWhereProductId(
            1
        );
        $this->assertSame(
            1,
            $result->getAffectedRows()
        );
    }

    public function test_updateSetSimilarRetrievedToUtcTimestampWhereProductId()
    {
        $result = $this->productIdTable->updateSetSimilarRetrievedToUtcTimestampWhereProductId(
            1
        );
        $this->assertSame(
            0,
            $result->getAffectedRows()
        );

        $this->productTable->insert(
            'ASIN001',
            'Title',
            'Product Group',
            null,
            null,
            4.99
        );
        $result = $this->productIdTable->updateSetSimilarRetrievedToUtcTimestampWhereProductId(
            1
        );
        $this->assertSame(
            1,
            $result->getAffectedRows()
        );
    }
}
