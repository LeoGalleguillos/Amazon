<?php
namespace LeoGalleguillos\AmazonTest\Model\Factory;

use ArrayObject;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Image\Model\Factory as ImageFactory;
use PHPUnit\Framework\TestCase;

class ProductGroupTest extends TestCase
{
    protected function setUp()
    {
        $this->productGroupTableMock = $this->createMock(
            AmazonTable\ProductGroup::class
        );

        $this->productGroupFactory = new AmazonFactory\ProductGroup(
            $this->productGroupTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonFactory\ProductGroup::class,
            $this->productGroupFactory
        );
    }

    public function testBuildFromArray()
    {
        $array = [
            'product_group_id' => '123',
            'name'             => 'the-name',
            'slug'             => 'the-slug',
            'search_table'     => 'the-search-table',
        ];
        $productGroupEntity = new AmazonEntity\ProductGroup();
        $productGroupEntity->setProductGroupId($array['product_group_id'])
                           ->setName($array['name'])
                           ->setSlug($array['slug'])
                           ->setSearchTable($array['search_table']);
        $this->assertEquals(
            $productGroupEntity,
            $this->productGroupFactory->buildFromArray($array)
        );
    }

    public function testBuildFromProductGroupId()
    {
        $arrayObject = new ArrayObject([
            'product_group_id' => 1,
            'name' => 'Test',
            'slug' => 'test',
            'search_table' => 'search_product_group_test',
        ]);
        $this->productGroupTableMock->method('selectWhereProductGroupId')->willReturn(
            $arrayObject
        );
        $productGroupEntity                 = new AmazonEntity\ProductGroup();
        $productGroupEntity->setProductGroupId(1);
        $productGroupEntity->name           = 'Test';
        $productGroupEntity->slug           = 'test';

        $productGroupEntity->setSearchTable('search_product_group_test');

        $this->assertEquals(
            $productGroupEntity,
            $this->productGroupFactory->buildFromProductGroupId(1)
        );
    }
}
