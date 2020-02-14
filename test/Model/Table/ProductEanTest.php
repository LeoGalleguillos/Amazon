<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Test\TableTestCase;

class ProductEanTest extends TableTestCase
{
    protected function setUp()
    {
        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTables(['product', 'product_ean']);
        $this->setForeignKeyChecks(1);

        $this->productTable = new AmazonTable\Product(
            $this->createMock(MemcachedService\Memcached::class),
            $this->getAdapter()
        );
        $this->productEanTable = new AmazonTable\ProductEan(
            $this->getAdapter()
        );
    }

    public function testInsertIgnore()
    {
        $result = $this->productEanTable->insertIgnore(1, '1234567890123');
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

        $result = $this->productEanTable->insertIgnore(1, '1234567890123');
        $this->assertSame(
            1,
            $result->getAffectedRows()
        );
        $this->assertSame(
            '0',
            $result->getGeneratedValue()
        );

        $result = $this->productEanTable->insertIgnore(1, '1234567890123');
        $this->assertSame(
            0,
            $result->getAffectedRows()
        );
        $this->assertSame(
            '0',
            $result->getGeneratedValue()
        );

        $result = $this->productEanTable->insertIgnore(1, '0234567890123');
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
