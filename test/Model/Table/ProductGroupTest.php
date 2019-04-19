<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use ArrayObject;
use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Test\TableTestCase;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class ProductGroupTest extends TableTestCase
{
    protected function setUp()
    {
        $this->memcachedService = $this->createMock(MemcachedService\Memcached::class);
        $this->productGroupTable     = new AmazonTable\ProductGroup(
            $this->memcachedService,
            $this->getAdapter()
        );

        $this->dropTable('product_group');
        $this->createTable('product_group');
    }

    public function testInsertIgnore()
    {
        $this->assertSame(
            1,
            $this->productGroupTable->insertIgnore('name', 'slug', 'search_product_group_test')
        );
        $this->assertSame(
            2,
            $this->productGroupTable->insertIgnore('another name', 'another-slug')
        );
        $this->assertSame(
            0,
            $this->productGroupTable->insertIgnore('name', 'slug', 'search_product_group_test')
        );
    }

    public function testGetAsins()
    {
        $this->assertEmpty(
            $this->productGroupTable->getAsins('Toy', rand(1, 999))
        );
    }

    public function testSelectWhereProductGroupId()
    {
        $this->productGroupTable->insertIgnore('name', 'slug', 'search_product_group_test');
        $arrayObject = new ArrayObject([
            'product_group_id' => '1',
            'name' => 'name',
            'slug' => 'slug',
            'search_table' => 'search_product_group_test',
        ]);
        $this->assertEquals(
            $arrayObject,
            $this->productGroupTable->selectWhereProductGroupId(1)
        );

        try {
            $this->productGroupTable->selectWhereProductGroupId(2);
            $this->fail();
        } catch (Exception $exception) {
            $this->assertSame(
                'Product group ID not found.',
                $exception->getMessage()
            );
        }
    }

    public function testSelectWhereSearchTableIsNotNull()
    {
        $this->productGroupTable->insertIgnore('name', 'slug', 'search_table_1');
        $this->productGroupTable->insertIgnore('another name', 'another-slug');
        $this->productGroupTable->insertIgnore('name2', 'slug2', 'search_table_2');
        $this->productGroupTable->insertIgnore('name3', 'slug3', 'search_table_3');

        foreach ($this->productGroupTable->selectWhereSearchTableIsNotNull() as $array) {
            $this->assertInternalType('array', $array);
        }
    }
}
