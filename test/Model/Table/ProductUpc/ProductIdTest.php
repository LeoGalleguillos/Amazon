<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\ProductUpc;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Test\TableTestCase;

class ProductIdTest extends TableTestCase
{
    protected function setUp()
    {
        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTable('product_upc');
        $this->setForeignKeyChecks(1);

        $this->productUpcTable = new AmazonTable\ProductUpc(
            $this->getAdapter()
        );
        $this->productIdTable = new AmazonTable\ProductUpc\ProductId(
            $this->getAdapter(),
            $this->productUpcTable
        );
    }

    public function testSelect()
    {
        // Select non-existent product ID should return no rows.
        $result = $this->productIdTable->selectWhereProductId(12345);
        $this->assertEmpty(
            iterator_to_array($result)
        );

        $this->setForeignKeyChecks(0);
        $this->productUpcTable->insertIgnore(
            12345,
            '123456789012'
        );
        $this->productUpcTable->insertIgnore(
            67890,
            '999999999999'
        );
        $this->productUpcTable->insertIgnore(
            12345,
            '000000000003'
        );
        // Purposely insert ignore a duplicate.
        $this->productUpcTable->insertIgnore(
            12345,
            '000000000003'
        );
        $this->productUpcTable->insertIgnore(
            12345,
            '777777777771'
        );
        $this->setForeignKeyChecks(1);

        $result = $this->productIdTable->selectWhereProductId(12345);
        $array  = iterator_to_array($result);

        // Assert that UPC's are in ascending order.
        $this->assertSame(
            '000000000003',
            $array[0]['upc']
        );
        $this->assertSame(
            '123456789012',
            $array[1]['upc']
        );
        $this->assertSame(
            '777777777771',
            $array[2]['upc']
        );
    }
}
