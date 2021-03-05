<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\Product;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use MonthlyBasis\LaminasTest\TableTestCase as TableTestCase;

class ProductGroupBindingTest extends TableTestCase
{
    protected function setUp(): void
    {
        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTable('product');
        $this->setForeignKeyChecks(1);

        $this->productTable = new AmazonTable\Product(
            $this->getAdapter()
        );
        $this->productGroupBindingTable = new AmazonTable\Product\ProductGroupBinding(
            $this->getAdapter(),
            $this->productTable
        );
    }

    public function test_selectWhereProductGroupBinding()
    {
        $result = $this->productGroupBindingTable
            ->selectWhereProductGroupBinding(
                'Product Group',
                'Binding'
            );
        $this->assertEmpty($result);

        $this->productTable->insert(
            'ASIN001',
            'Title',
            'Product Group',
            'Binding',
            'Brand',
            4.99
        );
        $result = $this->productGroupBindingTable
            ->selectWhereProductGroupBinding(
                'Product Group',
                'Binding'
            );
        $array = $result->current();
        $this->assertSame(
            'ASIN001',
            $array['asin']
        );
        $this->assertSame(
            'Binding',
            $array['binding']
        );
    }
}
