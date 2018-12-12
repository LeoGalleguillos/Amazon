<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;

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
            'asin',
            'title'
        );
        $this->assertSame(
            1,
            $productVideoId
        );

        $productVideoId = $this->productVideoTable->insert(
            67890,
            'asin',
            'title'
        );
        $this->assertSame(
            2,
            $productVideoId
        );
    }
}
