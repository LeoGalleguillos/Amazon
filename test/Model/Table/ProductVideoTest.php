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

        $this->dropTable('browse_node_product');
        $this->createTable('browse_node_product');

        $this->dropTable('product');
        $this->createTable('product');

        $this->dropTable('product_video');
        $this->createTable('product_video');

        $this->setForeignKeyChecks1();
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
            null,
            1
        );

        $productVideoId = $this->productVideoTable->insertOnDuplicateKeyUpdate(
            1,
            'ASIN',
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
            'ASIN',
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
            'ASIN2',
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
        $array = iterator_to_array(
            $this->productVideoTable->selectAsinWhereMatchAgainst('query')
        );
        $this->assertEmpty(
            $array
        );
    }

    public function testSelectProductVideoIdWhereBrowseNodeId()
    {
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(
            123,
            11111,
            null,
            1
        );
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(
            321,
            22222,
            null,
            1
        );
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(
            123,
            33333,
            null,
            1
        );
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            11111,
            'ASIN001',
            'Title',
            'Description',
            1000
        );
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            22222,
            'ASIN002',
            'Title',
            'Description',
            1000
        );
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            33333,
            'ASIN003',
            'Title',
            'Description',
            1000
        );

        $result = $this->productVideoTable->selectProductVideoIdWhereBrowseNodeId(
            123,
            0,
            100
        );
        $this->assertSame(
            iterator_to_array($result),
            [
                ['product_video_id' => '1'],
                ['product_video_id' => '3'],
            ]
        );
    }

    public function testSelectWhereModifiedIsNullAndBrowseNodeIdIsNullLimit1()
    {
        try {
            $this->productVideoTable->selectWhereModifiedIsNullAndBrowseNodeIdIsNullLimit1();
            $this->fail();
        } catch (TypeError $typeError) {
            $this->assertSame(
                'Return value of',
               substr($typeError->getMessage(), 0, 15)
            );
        }

        $productVideoId = $this->productVideoTable->insertOnDuplicateKeyUpdate(
            12345,
            'ASIN',
            'title',
            'description',
            3000
        );
        $array = $this->productVideoTable->selectWhereModifiedIsNullAndBrowseNodeIdIsNullLimit1();

        $this->assertSame(
            '1',
            $array['product_video_id']
        );
        $this->assertSame(
            '12345',
            $array['product_id']
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
            'ASIN',
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
