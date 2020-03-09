<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\Product;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase as TableTestCase;

class ProductIdTest extends TableTestCase
{
    protected function setUp()
    {
        $this->productTable = new AmazonTable\Product(
            $this->getAdapter()
        );
        $this->productIdTable = new AmazonTable\Product\ProductId(
            $this->getAdapter(),
            $this->productTable
        );

        $this->setForeignKeyChecks0();
        $this->dropTable('product');
        $this->createTable('product');
        $this->setForeignKeyChecks1();
    }

    public function test_selectWhereProductIdIn()
    {
        $generator = $this->productIdTable->selectWhereProductIdIn([1, 2, 3]);
        $this->assertEmpty(
            iterator_to_array($generator)
        );

    }
}
