<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Test\TableTestCase;

class ProductTest extends TableTestCase
{
    protected function setUp()
    {
        $this->memcachedService = $this->createMock(MemcachedService\Memcached::class);
        $this->productTable     = new AmazonTable\Product(
            $this->memcachedService,
            $this->getAdapter()
        );

        $this->setForeignKeyChecks0();
        $this->dropTable('product');
        $this->createTable('product');
        $this->setForeignKeyChecks1();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonTable\Product::class,
            $this->productTable
        );
    }
}
