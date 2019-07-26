<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\ProductVideo;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;

class ProductIdTest extends TableTestCase
{
    protected function setUp()
    {
        $this->productIdTable = new AmazonTable\ProductVideo\ProductId(
            $this->getAdapter()
        );
        $this->productVideoTable = new AmazonTable\ProductVideo(
            $this->getAdapter()
        );

        $this->dropTable('product_video');
        $this->createTable('product_video');
    }

    public function testDeleteWhereProductId()
    {
        $affectedRows = $this->productIdTable->deleteWhereProductId(12345);
        $this->assertSame(
            0,
            $affectedRows
        );

        $productVideoId = $this->productVideoTable->insertOnDuplicateKeyUpdate(
            54321,
            'ASIN',
            'video title',
            'video description',
            1000
        );

        $affectedRows = $this->productIdTable->deleteWhereProductId(12345);
        $this->assertSame(
            0,
            $affectedRows
        );

        $affectedRows = $this->productIdTable->deleteWhereProductId(54321);
        $this->assertSame(
            1,
            $affectedRows
        );
    }
}
