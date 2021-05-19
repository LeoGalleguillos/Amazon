<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\Product;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase as TableTestCase;

class ProductGroupIsValidSimilarRetrievedTest extends TableTestCase
{
    protected function setUp(): void
    {
        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTable('product');
        $this->setForeignKeyChecks(1);

        $this->productTable = new AmazonTable\Product(
            $this->getAdapter()
        );
        $this->productIdTable = new AmazonTable\Product\ProductId(
            $this->getAdapter(),
            $this->productTable
        );
        $this->productGroupIsValidSimilarRetrievedTable = new AmazonTable\Product\ProductGroupIsValidSimilarRetrieved(
            $this->getAdapter(),
            $this->productTable
        );
    }

    public function test_selectOrderBySimilarRetrievedAscModifiedAscProductIdAscLimit1_multipleProducts()
    {
        $this->productTable->insert(
            'ASIN001',
            'Title',
            'Product Group',
            null,
            null,
            4.99
        );
        $this->productTable->insert(
            'ASIN002',
            'Title',
            'Different Product Group',
            null,
            null,
            4.99
        );
        $this->productTable->insert(
            'ASIN003',
            'Title',
            'Product Group',
            null,
            null,
            4.99
        );

        $result = $this->productGroupIsValidSimilarRetrievedTable
            ->selectWhereProductGroupIsValid1OrderBySimilarRetrievedAscProductIdAscLimit1('Product Group');
        $array = $result->current();
        $this->assertSame(
            'ASIN001',
            $array['asin']
        );

        $this->productIdTable->updateSetSimilarRetrievedToUtcTimestampWhereProductId(
            1
        );
        $result = $this->productGroupIsValidSimilarRetrievedTable
            ->selectWhereProductGroupIsValid1OrderBySimilarRetrievedAscProductIdAscLimit1('Product Group');
        $array = $result->current();
        $this->assertSame(
            'ASIN003',
            $array['asin']
        );
    }
}
