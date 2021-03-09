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

    public function test_selectWhereProductGroup_emptyResult()
    {
        $result = $this->productGroupTable->selectWhereProductGroup(
            'Product Group',
            0,
            100
        );
        $this->assertEmpty($result);
    }

    public function test_selectWhereProductGroup_specificResults()
    {
        $this->productTable->insert(
            'ASIN1',
            'Title',
            'Product Group',
            'Binding',
            'Brand',
            4.99
        );
        $this->productTable->insert(
            'ASIN2',
            'Title',
            'Product Group 2',
            'Binding',
            'Brand',
            4.99
        );
        $this->productTable->insert(
            'ASIN3',
            'Title',
            'Product Group',
            'Binding',
            'Brand',
            4.99
        );

        $result = $this->productGroupTable->selectWhereProductGroup(
            'Product Group',
            0,
            10
        );
        $array = $result->current();
        $this->assertSame(
            'ASIN3',
            $array['asin']
        );
        $this->assertSame(
            'Binding',
            $array['binding']
        );
        $array = $result->next();
        $this->assertSame(
            'ASIN1',
            $array['asin']
        );

        $result = $this->productGroupTable->selectWhereProductGroup(
            'Product Group',
            1,
            1
        );
        $array = $result->current();
        $this->assertSame(
            'ASIN1',
            $array['asin']
        );
        $this->assertFalse(
            $result->next()
        );
    }
}
