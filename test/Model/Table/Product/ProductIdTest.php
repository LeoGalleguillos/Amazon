<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\Product;

use Exception;
use Generator;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase as TableTestCase;

class ProductIdTest extends TableTestCase
{
    protected function setUp()
    {
        $this->productTableMock = $this->createMock(
            AmazonTable\Product::class
        );
        $this->productIdTable = new AmazonTable\Product\ProductId(
            $this->getAdapter(),
            $this->productTableMock
        );


        $this->setForeignKeyChecks0();
        $this->dropTable('product');
        $this->createTable('product');
        $this->setForeignKeyChecks1();
    }

    public function testSelectAsinWhereProductIdIn()
    {
        $generator = $this->productIdTable->selectAsinWhereProductIdIn([1, 2, 3]);
        $this->assertSame(
            [],
            iterator_to_array($generator)
        );

    }
}
