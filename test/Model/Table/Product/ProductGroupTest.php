<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\Product;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use MonthlyBasis\LaminasTest\TableTestCase as TableTestCase;

class ProductGroup extends TableTestCase
{
    protected function setUp(): void
    {
        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTable('product');
        $this->setForeignKeyChecks(1);

        $this->productTable = new AmazonTable\Product(
            $this->getAdapter()
        );
        $this->productGroupTable = new AmazonTable\Product\ProductGroup(
            $this->getAdapter(),
            $this->productTable
        );
    }

    public function test_selectWhereProductGroup()
    {
        $result = $this->productGroupTable
            ->selectWhereProductGroup(
                'Product Group'
            );
        $this->assertEmpty($result);

        $this->productTable->insert(
            'ASIN123',
            'Title',
            'Product Group',
            'Binding',
            'Brand',
            4.99
        );
        $result = $this->productGroupTable
            ->selectWhereProductGroup(
                'Product Group'
            );
        $array = $result->current();
        $this->assertSame(
            'ASIN123',
            $array['asin']
        );
        $this->assertSame(
            'Binding',
            $array['binding']
        );
    }
}
