<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use Generator;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Test\TableTestCase;
use TypeError;

class ProductVideoTest extends TableTestCase
{
    protected function setUp()
    {
        $this->browseNodeTable = new AmazonTable\BrowseNode(
            $this->getAdapter()
        );
        $this->browseNodeProductTable = new AmazonTable\BrowseNodeProduct(
            $this->getAdapter()
        );
        $this->productTable = new AmazonTable\Product(
            $this->createMock(MemcachedService\Memcached::class),
            $this->getAdapter()
        );
        $this->productVideoTable = new AmazonTable\ProductVideo(
            $this->getAdapter()
        );

        $this->setForeignKeyChecks0();
        $this->dropTable('product');
        $this->createTable('product');
        $this->setForeignKeyChecks1();

        $this->dropTable('product_video');
        $this->createTable('product_video');
    }

    public function testInsert()
    {
        $this->browseNodeTable->insertIgnore(
            12345,
            'Browse Node Name'
        );
        $this->productTable->insert(
            'asin',
            'product title',
            'product group',
            null,
            null,
            0
        );
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(
            12345,
            1,
            1
        );

        $productVideoId = $this->productVideoTable->insertOnDuplicateKeyUpdate(
            1,
            'video title',
            'video description',
            1000
        );
        $this->assertSame(
            1,
            $productVideoId
        );

        $array = $this->productVideoTable->selectWhereProductVideoId(1);
        $this->assertSame(
            '1000',
            $array['duration_milliseconds']
        );
        $this->assertSame(
            'video title',
            $array['title']
        );
        $this->assertSame(
            'Browse Node Name',
            $array['browse_node.name']
        );
        $this->assertNull(
            $array['modified']
        );

        $productVideoId = $this->productVideoTable->insertOnDuplicateKeyUpdate(
            1,
            'video title',
            'video description',
            12345
        );
        $this->assertSame(
            1,
            $productVideoId
        );
        $array = $this->productVideoTable->selectWhereProductVideoId(1);
        $this->assertSame(
            '12345',
            $array['duration_milliseconds']
        );
        $this->assertNotNull(
            $array['modified']
        );

        $productVideoId = $this->productVideoTable->insertOnDuplicateKeyUpdate(
            67890,
            'title 2',
            'description 2',
            2000
        );
        $this->assertSame(
            3,
            $productVideoId
        );
    }

    public function testSelectAsinWhereMatchAgainst()
    {
        $generator = $this->productVideoTable->selectAsinWhereMatchAgainst('query');
        $this->assertInstanceOf(
            Generator::class,
            $generator
        );
    }

    public function testSelectWhereBrowseNodeId()
    {
        $generator = $this->productVideoTable->selectWhereBrowseNodeId(
            123,
            0,
            100
        );
        $this->assertSame(
            iterator_to_array($generator),
            []
        );
    }

    public function testSelectWhereProductId()
    {
        try {
            $this->productVideoTable->selectWhereProductId(12345);
            $this->fail();
        } catch (TypeError $typeError) {
            $this->assertSame(
                'Return value of',
               substr($typeError->getMessage(), 0, 15)
            );
        }

        $productVideoId = $this->productVideoTable->insertOnDuplicateKeyUpdate(
            12345,
            'title',
            'description',
            3000
        );
        $array = $this->productVideoTable->selectWhereProductId(12345);

        $this->assertSame(
            '1',
            $array['product_video_id']
        );
        $this->assertSame(
            '12345',
            $array['product_id']
        );
    }
}
