<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\Product;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase as TableTestCase;

class SimilarRetrievedModifiedProductIdTest extends TableTestCase
{
    protected function setUp()
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
        $this->similarRetrievedModifiedProductIdTable = new AmazonTable\Product\SimilarRetrievedModifiedProductId(
            $this->getAdapter(),
            $this->productTable
        );
    }

    public function test_selectOrderBySimilarRetrievedAscModifiedAscProductIdAscLimit1_multipleProducts()
    {
        $this->productTable->insertAsin('ASIN001');
        $this->productTable->insertAsin('ASIN002');
        $this->productTable->insertAsin('ASIN003');

        $result = $this->similarRetrievedModifiedProductIdTable
            ->selectOrderBySimilarRetrievedAscModifiedAscProductIdAscLimit1();
        $array = $result->current();
        $this->assertSame(
            'ASIN001',
            $array['asin']
        );

        $this->productIdTable->updateSetModifiedToUtcTimestampWhereProductId(
            1
        );
        $result = $this->similarRetrievedModifiedProductIdTable
            ->selectOrderBySimilarRetrievedAscModifiedAscProductIdAscLimit1();
        $array = $result->current();
        $this->assertSame(
            'ASIN002',
            $array['asin']
        );
    }
}
