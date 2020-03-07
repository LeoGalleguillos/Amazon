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
        $this->dropAndCreateTables([
            'browse_node',
            'browse_node_product',
            'product',
            'product_video',
        ]);
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

        $this->productTable->insert(
            'asin2',
            'product title',
            'product group',
            null,
            null,
            0
        );
        $productVideoId = $this->productVideoTable->insertOnDuplicateKeyUpdate(
            2,
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
        $this->browseNodeTable->insertIgnore(
            123,
            'category 123'
        );
        $this->browseNodeTable->insertIgnore(
            321,
            'category 321'
        );
        $this->productTable->insert(
            'asin1',
            'product title',
            'product group',
            null,
            null,
            0
        );
        $this->productTable->insert(
            'asin2',
            'product title',
            'product group',
            null,
            null,
            0
        );
        $this->productTable->insert(
            'asin3',
            'product title',
            'product group',
            null,
            null,
            0
        );
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(
            123,
            1,
            null,
            1
        );
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(
            321,
            2,
            null,
            1
        );
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(
            123,
            3,
            null,
            1
        );
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            1,
            'ASIN001',
            'Title',
            'Description',
            1000
        );
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            2,
            'ASIN002',
            'Title',
            'Description',
            1000
        );
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            3,
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

        $this->productTable->insert(
            'asin',
            'product title',
            'product group',
            null,
            null,
            0
        );
        $productVideoId = $this->productVideoTable->insertOnDuplicateKeyUpdate(
            1,
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
            '1',
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

        $this->productTable->insert(
            'asin',
            'product title',
            'product group',
            null,
            null,
            0
        );
        $productVideoId = $this->productVideoTable->insertOnDuplicateKeyUpdate(
            1,
            'ASIN',
            'title',
            'description',
            3000
        );
        $array = $this->productVideoTable->selectWhereProductId(1);

        $this->assertSame(
            '1',
            $array['product_video_id']
        );
        $this->assertSame(
            '1',
            $array['product_id']
        );
    }
}
