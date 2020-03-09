<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;

class ProductIsbnTest extends TableTestCase
{
    protected function setUp()
    {
        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTables(['product', 'product_isbn']);
        $this->setForeignKeyChecks(1);

        $this->productTable = new AmazonTable\Product(
            $this->getAdapter()
        );
        $this->productIsbnTable = new AmazonTable\ProductIsbn(
            $this->getAdapter()
        );
    }

    public function testGetSelect()
    {
        $this->assertInternalType(
            'string',
            $this->productIsbnTable->getSelect()
        );
    }

    public function testInsertIgnore()
    {
        // Insert for non-existent product ID should affect 0 rows.
        $result = $this->productIsbnTable->insertIgnore(1, '1234567890');
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
        $result = $this->productIsbnTable->insertIgnore(1, '1234567890');
        $this->assertSame(
            1,
            $result->getAffectedRows()
        );
        $this->assertSame(
            '0',
            $result->getGeneratedValue()
        );

        // Inserting duplicate ISBN should affect 0 rows.
        $result = $this->productIsbnTable->insertIgnore(1, '1234567890');
        $this->assertSame(
            0,
            $result->getAffectedRows()
        );
        $this->assertSame(
            '0',
            $result->getGeneratedValue()
        );

        /*
            Insert new ISBN with existing product ID should succeed.
            There is no auto-increment ID, so generated value should be '0'.
         */
        $result = $this->productIsbnTable->insertIgnore(1, '0234567890');
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
