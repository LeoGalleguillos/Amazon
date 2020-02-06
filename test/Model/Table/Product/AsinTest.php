<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\Product;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Test\TableTestCase as TableTestCase;
use TypeError;

class AsinTest extends TableTestCase
{
    protected function setUp()
    {
        $this->productTable = new AmazonTable\Product(
            $this->createMock(MemcachedService\Memcached::class),
            $this->getAdapter()
        );
        $this->asinTable = new AmazonTable\Product\Asin(
            $this->getAdapter(),
            $this->productTable
        );

        $this->dropTable('product');
        $this->createTable('product');
    }

    public function testSelectProductIdWhereAsin()
    {
        try {
            $array = $this->asinTable->selectProductIdWhereAsin('ASIN001');
            $this->fail();
        } catch (TypeError $typeError) {
            $this->assertSame(
                'Return value of',
                substr($typeError->getMessage(), 0, 15)
            );
        }

        $this->productTable->insert(
            'ASIN001',
            'Title',
            'Product Group',
            null,
            null,
            4.99
        );

        $array = $this->asinTable->selectProductIdWhereAsin('ASIN001');
        $this->assertSame(
            '1',
            $array['product_id']
        );
    }

    public function testUpdateSetModifiedToUtcTimestampWhereAsin()
    {
        $affectedRows = $this->asinTable->updateSetModifiedToUtcTimestampWhereAsin('ASIN001');
        $this->assertSame(
            0,
            $affectedRows
        );

        $this->productTable->insert(
            'ASIN001',
            'Title',
            'Product Group',
            null,
            null,
            4.99
        );

        $affectedRows = $this->asinTable->updateSetModifiedToUtcTimestampWhereAsin('ASIN001');
        $this->assertSame(
            1,
            $affectedRows
        );
    }

    public function testUpdateSetInvalidWhereAsin()
    {
        $affectedRows = $this->asinTable->updateSetInvalidWhereAsin(0, 'ASIN001');
        $this->assertSame(
            0,
            $affectedRows
        );

        $this->productTable->insert(
            'ASIN001',
            'Title',
            'Product Group',
            null,
            null,
            4.99
        );

        $affectedRows = $this->asinTable->updateSetInvalidWhereAsin(0, 'ASIN001');
        $this->assertSame(
            1,
            $affectedRows
        );
        $affectedRows = $this->asinTable->updateSetInvalidWhereAsin(1, 'ASIN001');
        $this->assertSame(
            1,
            $affectedRows
        );
        $affectedRows = $this->asinTable->updateSetInvalidWhereAsin(1, 'ASIN001');
        $this->assertSame(
            0,
            $affectedRows
        );
    }
}
