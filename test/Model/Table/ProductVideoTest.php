<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;
use TypeError;

class ProductVideoTest extends TableTestCase
{
    protected function setUp()
    {
        $this->productVideoTable = new AmazonTable\ProductVideo(
            $this->getAdapter()
        );

        $this->dropTable('product_video');
        $this->createTable('product_video');
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonTable\ProductVideo::class,
            $this->productVideoTable
        );
    }

    public function testInsert()
    {
        $productVideoId = $this->productVideoTable->insert(
            12345,
            'title'
        );
        $this->assertSame(
            1,
            $productVideoId
        );

        $productVideoId = $this->productVideoTable->insert(
            67890,
            'title 2'
        );
        $this->assertSame(
            2,
            $productVideoId
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

        $productVideoId = $this->productVideoTable->insert(
            12345,
            'title'
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
