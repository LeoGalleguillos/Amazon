<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\Product;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use MonthlyBasis\LaminasTest\TableTestCase as TableTestCase;

class ProductGroupBindingBrandTest extends TableTestCase
{
    protected function setUp(): void
    {
        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTable('product');
        $this->setForeignKeyChecks(1);

        $this->productTable = new AmazonTable\Product(
            $this->getAdapter()
        );
        $this->productGroupBindingBrandTable = new AmazonTable\Product\ProductGroupBindingBrand(
            $this->getAdapter(),
            $this->productTable
        );
    }

    public function test_selectWhereProductGroupBindingBrand()
    {
        $result = $this->productGroupBindingBrandTable
            ->selectWhereProductGroupBindingBrand(
                'Product Group',
                'Binding',
                'Brand'
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
        $result = $this->productGroupBindingBrandTable
            ->selectWhereProductGroupBindingBrand(
                'Product Group',
                'Binding',
                'Brand'
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
