<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\ProductVideo;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;

class ProductVideoIdTest extends TableTestCase
{
    protected function setUp()
    {
        $this->productVideoIdTable = new AmazonTable\ProductVideo\ProductVideoId(
            $this->getAdapter()
        );
        $this->productVideoTable = new AmazonTable\ProductVideo(
            $this->getAdapter()
        );

        $this->dropTable('product_video');
        $this->createTable('product_video');
    }

    public function testUpdateSetModifiedToUtcTimestampWhereProductVideoId()
    {
        $affectedRows = $this->productVideoIdTable
            ->updateSetModifiedToUtcTimestampWhereProductVideoId(
                1
            );
        $this->assertSame(
            0,
            $affectedRows
        );

        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            123,
            'ASIN',
            'Title',
            'Description',
            9999
        );
        $affectedRows = $this->productVideoIdTable
            ->updateSetModifiedToUtcTimestampWhereProductVideoId(
                1
            );
        $this->assertSame(
            1,
            $affectedRows
        );
    }

    public function testUpdateSetViewsToViewsPlusOneWhereProductVideoId()
    {
        $affectedRows = $this->productVideoIdTable->updateSetViewsToViewsPlusOneWhereProductVideoId(
            1
        );
        $this->assertSame(
            0,
            $affectedRows
        );

        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            123,
            'ASIN',
            'Title',
            'Description',
            9999
        );
        $affectedRows = $this->productVideoIdTable->updateSetViewsToViewsPlusOneWhereProductVideoId(
            1
        );
        $this->assertSame(
            1,
            $affectedRows
        );
    }
}
