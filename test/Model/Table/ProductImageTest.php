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

    public function test_deleteWhereProductId_emptyTable_0affectedRows()
    {
        $result = $this->productImageTable->deleteWhereProductId(54321);
        $this->assertSame(
            0,
            $result->getAffectedRows()
        );
    }

    public function test_deleteWhereProductId_nonEmptyTable_2affectedRows()
    {
        $this->setForeignKeyChecks(0);

        $this->productImageTable->insertIgnore(
            444,
            'primary',
            'https://www.example.com/photo1.jpg',
            100,
            200
        );
        $this->productImageTable->insertIgnore(
            444,
            'variant',
            'https://www.example.com/photo2.jpg',
            100,
            200
        );
        $this->productImageTable->insertIgnore(
            2,
            'primary',
            'https://www.example.com/photo2-1.jpg',
            100,
            200
        );
        $result = $this->productImageTable->deleteWhereProductId(444);
        $this->assertSame(
            2,
            $result->getAffectedRows()
        );
        $result = $this->productImageTable->deleteWhereProductId(2);
        $this->assertSame(
            1,
            $result->getAffectedRows()
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
