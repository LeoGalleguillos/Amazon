<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use ArrayObject;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Test\TableTestCase;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

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
        $this->assertInstanceOf(AmazonTable\Product::class, $this->productTable);
    }

    public function testInsertOnDuplicateKeyUpdate()
    {
        $productGroupEntity = new AmazonEntity\ProductGroup();
        $productGroupEntity->setName('Test');

        $productEntity       = new AmazonEntity\Product();
        $productEntity->asin  = 'ASIN';
        $productEntity->setTitle('Test Product');
        $productEntity->listPrice = 0.00;
        $productEntity->setProductGroup($productGroupEntity);
        $productEntity->binding = 'Binding';
        $productEntity->brand = 'Brand';

        $this->assertSame(
            1,
            $this->productTable->insertOnDuplicateKeyUpdate($productEntity)
        );
        $this->assertSame(
            0,
            $this->productTable->insertOnDuplicateKeyUpdate($productEntity)
        );
    }

    public function testSelectAsinWhereProductGroupAndSimilarRetrievedIsNull()
    {
        $this->assertFalse(
            $this->productTable->selectAsinWhereProductGroupAndSimilarRetrievedIsNull(
                'Toy'
            )
        );

        $productGroupEntity = new AmazonEntity\ProductGroup();
        $productGroupEntity->setName('Toy');

        $productEntity       = new AmazonEntity\Product();
        $productEntity->asin  = 'ASIN';
        $productEntity->setTitle('Test Product');
        $productEntity->listPrice = 0.00;
        $productEntity->setProductGroup($productGroupEntity);
        $productEntity->binding = 'Binding';
        $productEntity->brand = 'Brand';
        $this->productTable->insertOnDuplicateKeyUpdate($productEntity);

        $this->assertSame(
            'ASIN',
            $this->productTable->selectAsinWhereProductGroupAndSimilarRetrievedIsNull(
                'Toy'
            )
        );
    }

    public function testSelectWhereProductId()
    {
        $productGroupEntity = new AmazonEntity\ProductGroup();
        $productGroupEntity->setName('Test');

        $productEntity       = new AmazonEntity\Product();
        $productEntity->asin  = 'ASIN';
        $productEntity->setTitle('Test Product');
        $productEntity->listPrice = 0.00;
        $productEntity->setProductGroup($productGroupEntity);
        $productEntity->binding = 'Binding';
        $productEntity->brand = 'Brand';

        $this->productTable->insertOnDuplicateKeyUpdate($productEntity);

        $this->assertInternalType(
            'array',
            $this->productTable->selectWhereProductId(1)
        );
    }
}
