<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;

class ProductUpcTest extends TableTestCase
{
    protected function setUp(): void
    {
        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTables(['product', 'product_upc']);
        $this->setForeignKeyChecks(1);

        $this->productTable = new AmazonTable\Product(
            $this->getAdapter()
        );
        $this->productUpcTable = new AmazonTable\ProductUpc(
            $this->getAdapter()
        );
    }

    public function testGetSelect()
    {
        $this->assertIsString(
            $this->productUpcTable->getSelect()
        );
    }

    public function testInsertIgnore()
    {
        // Insert for non-existent product ID should affect 0 rows.
        $result = $this->productUpcTable->insertIgnore(1, '123456789012');
        $this->assertSame(
            0,
            $result->getAffectedRows()
        );
        $this->assertSame(
            '0',
            $result->getGeneratedValue()
        );

        $this->productTable->insert(
            'ASIN',
            'Title',
            'Product Group',
            'Binding',
            'Brand',
            3.14
        );

        /*
            Insert new row with existing product ID should succeed.
            There is no auto-increment ID, so generated value should be '0'.
         */
        $result = $this->productUpcTable->insertIgnore(1, '123456789012');
        $this->assertSame(
            1,
            $result->getAffectedRows()
        );
        $this->assertSame(
            '0',
            $result->getGeneratedValue()
        );

        // Inserting duplicate UPC should affect 0 rows.
        $result = $this->productUpcTable->insertIgnore(1, '123456789012');
        $this->assertSame(
            0,
            $result->getAffectedRows()
        );
        $this->assertSame(
            '0',
            $result->getGeneratedValue()
        );

        /*
            Insert new UPC with existing product ID should succeed.
            There is no auto-increment ID, so generated value should be '0'.
         */
        $result = $this->productUpcTable->insertIgnore(1, '023456789012');
        $this->assertSame(
            1,
            $result->getAffectedRows()
        );
        $this->assertSame(
            '0',
            $result->getGeneratedValue()
        );
    }
}
