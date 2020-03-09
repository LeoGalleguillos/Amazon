<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;

class ProductImageTest extends TableTestCase
{
    protected function setUp()
    {
        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTables(['product', 'product_image']);
        $this->setForeignKeyChecks(1);

        $this->productTable = new AmazonTable\Product(
            $this->getAdapter()
        );
        $this->productImageTable = new AmazonTable\ProductImage(
            $this->getAdapter()
        );
    }

    public function testSelectWhereAsin()
    {
        $generator = $this->productImageTable->selectWhereAsin('ASIN009');
        $this->assertEmpty(
            iterator_to_array($generator)
        );
    }
}
