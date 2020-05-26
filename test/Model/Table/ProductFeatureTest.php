<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;

class ProductFeatureTest extends TableTestCase
{
    protected function setUp(): void
    {
        $this->productFeatureTable = new AmazonTable\ProductFeature(
            $this->getAdapter()
        );

        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTable('product_feature');
        $this->setForeignKeyChecks(1);
    }

    public function test_deleteWhereProductId_nonEmptyTable_2affectedRows()
    {
        $this->setForeignKeyChecks(0);

        $this->productFeatureTable->insert(
            444,
            'Product feature 1.'
        );
        $this->productFeatureTable->insert(
            444,
            'Product feature 2.'
        );
        $this->productFeatureTable->insert(
            22222,
            'Another product feature.'
        );
        $result = $this->productFeatureTable->deleteWhereProductId(444);
        $this->assertSame(
            2,
            $result->getAffectedRows()
        );
        $result = $this->productFeatureTable->deleteWhereProductId(2);
        $this->assertSame(
            0,
            $result->getAffectedRows()
        );
    }

    public function testSelectWhereProductId()
    {
        $generator = $this->productFeatureTable->selectWhereProductId(
            12345
        );
        $this->assertEmpty(
            iterator_to_array($generator)
        );
    }
}
