<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\ProductIsbn;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Test\TableTestCase;

class ProductIdTest extends TableTestCase
{
    protected function setUp(): void
    {
        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTable('product_isbn');
        $this->setForeignKeyChecks(1);

        $this->productIsbnTable = new AmazonTable\ProductIsbn(
            $this->getAdapter()
        );
        $this->productIdTable = new AmazonTable\ProductIsbn\ProductId(
            $this->getAdapter(),
            $this->productIsbnTable
        );
    }

    public function testSelect()
    {
        $result = $this->productIdTable->selectWhereProductId(12345);
        $this->assertEmpty(
            iterator_to_array($result)
        );

        $this->setForeignKeyChecks(0);
        $this->productIsbnTable->insertIgnore(
            12345,
            '1234567890'
        );
        $this->productIsbnTable->insertIgnore(
            67890,
            '9999999999'
        );
        $this->productIsbnTable->insertIgnore(
            12345,
            '0000000000'
        );
        // Purposely insert ignore a duplicate.
        $this->productIsbnTable->insertIgnore(
            12345,
            '0000000000'
        );
        $this->productIsbnTable->insertIgnore(
            12345,
            '7777777771'
        );
        $this->setForeignKeyChecks(1);

        $result = $this->productIdTable->selectWhereProductId(12345);
        $array  = iterator_to_array($result);

        // Assert that ISBN's are in ascending order.
        $this->assertSame(
            '0000000000',
            $array[0]['isbn']
        );
        $this->assertSame(
            '1234567890',
            $array[1]['isbn']
        );
        $this->assertSame(
            '7777777771',
            $array[2]['isbn']
        );
    }
}
