<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\ProductVideo;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Test\TableTestCase;

class ProductIdTest extends TableTestCase
{
    protected function setUp()
    {
        $this->productTable = new AmazonTable\Product(
            $this->createMock(MemcachedService\Memcached::class),
            $this->getAdapter()
        );
        $this->productIdTable = new AmazonTable\ProductVideo\ProductId(
            $this->getAdapter()
        );
        $this->productVideoTable = new AmazonTable\ProductVideo(
            $this->getAdapter()
        );

        $this->setForeignKeyChecks0();
        $this->dropAndCreateTables(['product', 'product_video']);
        $this->setForeignKeyChecks1();
    }

    public function testDeleteWhereProductId()
    {
        $affectedRows = $this->productIdTable->deleteWhereProductId(12345);
        $this->assertSame(
            0,
            $affectedRows
        );

        $this->productTable->insert(
            'asin1',
            'product title',
            'product group',
            null,
            null,
            0
        );
        $productVideoId = $this->productVideoTable->insertOnDuplicateKeyUpdate(
            1,
            'asin1',
            'video title',
            'video description',
            1000
        );

        $affectedRows = $this->productIdTable->deleteWhereProductId(12345);
        $this->assertSame(
            0,
            $affectedRows
        );

        $affectedRows = $this->productIdTable->deleteWhereProductId(1);
        $this->assertSame(
            1,
            $affectedRows
        );
    }

    public function testUpdateSetModifiedToUtcTimestampWhereProductId()
    {
        $affectedRows = $this->productIdTable
            ->updateSetModifiedToUtcTimestampWhereProductId(
                123
            );
        $this->assertSame(
            0,
            $affectedRows
        );

        $this->productTable->insert(
            'asin1',
            'product title',
            'product group',
            null,
            null,
            0
        );
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            1,
            'ASIN',
            'Title',
            'Description',
            9999
        );
        $affectedRows = $this->productIdTable
            ->updateSetModifiedToUtcTimestampWhereProductId(
                1
            );
        $this->assertSame(
            1,
            $affectedRows
        );
    }
}
