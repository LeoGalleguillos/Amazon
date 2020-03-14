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

    public function test_selectWhereProductId()
    {
        $generator = $this->productImageTable->selectWhereProductId(12345);
        $this->assertEmpty(
            iterator_to_array($generator)
        );
    }

    public function test_insertIgnore()
    {
        $this->productTable->insert(
            'ASIN001',
            'Title',
            'Product Group 01',
            null,
            null,
            0.00,
            1
        );
        $affectedRows = $this->productImageTable->insertIgnore(
            1,
            'primary',
            'https://www.example.com/photo.jpg',
            100,
            200
        );
        $this->assertSame(
            1,
            $affectedRows
        );
    }
}
