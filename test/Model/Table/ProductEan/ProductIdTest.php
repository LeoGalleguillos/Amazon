<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\ProductEan;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Test\TableTestCase;

class ProductIdTest extends TableTestCase
{
    protected function setUp(): void
    {
        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTable('product_ean');
        $this->setForeignKeyChecks(1);

        $this->productEanTable = new AmazonTable\ProductEan(
            $this->getAdapter()
        );
        $this->productIdTable = new AmazonTable\ProductEan\ProductId(
            $this->getAdapter(),
            $this->productEanTable
        );
    }

    public function testSelect()
    {
        $result = $this->productIdTable->selectWhereProductId(12345);
        $this->assertEmpty(
            iterator_to_array($result)
        );

        $this->setForeignKeyChecks(0);
        $this->productEanTable->insertIgnore(
            12345,
            '1234567890123'
        );
        $this->productEanTable->insertIgnore(
            67890,
            '9999999999999'
        );
        $this->productEanTable->insertIgnore(
            12345,
            '0000000000003'
        );
        // Purposely insert ignore a duplicate.
        $this->productEanTable->insertIgnore(
            12345,
            '0000000000003'
        );
        $this->productEanTable->insertIgnore(
            12345,
            '7777777777771'
        );
        $this->setForeignKeyChecks(1);

        $result = $this->productIdTable->selectWhereProductId(12345);
        $array  = iterator_to_array($result);

        // Assert that EAN's are in ascending order.
        $this->assertSame(
            '0000000000003',
            $array[0]['ean']
        );
        $this->assertSame(
            '1234567890123',
            $array[1]['ean']
        );
        $this->assertSame(
            '7777777777771',
            $array[2]['ean']
        );
    }
}
