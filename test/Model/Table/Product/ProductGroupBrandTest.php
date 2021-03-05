<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\Product;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use MonthlyBasis\LaminasTest\TableTestCase as TableTestCase;

class ProductGroupBrandTest extends TableTestCase
{
    protected function setUp(): void
    {
        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTable('product');
        $this->setForeignKeyChecks(1);

        $this->productTable = new AmazonTable\Product(
            $this->getAdapter()
        );
        $this->productGroupBrandTable = new AmazonTable\Product\ProductGroupBrand(
            $this->getAdapter(),
            $this->productTable
        );
    }

    public function test_selectWhereProductGroupBrand()
    {
        $result = $this->productGroupBrandTable
            ->selectWhereProductGroupBrand(
                'Product Group',
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
        $result = $this->productGroupBrandTable
            ->selectWhereProductGroupBrand(
                'Product Group',
                'Brand'
            );
        $array = $result->current();
        $this->assertSame(
            'ASIN001',
            $array['asin']
        );
        $this->assertSame(
            'Brand',
            $array['brand']
        );
    }
}
