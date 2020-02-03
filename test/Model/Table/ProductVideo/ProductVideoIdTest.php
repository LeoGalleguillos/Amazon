<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\ProductVideo;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;

class ProductVideoIdTest extends TableTestCase
{
    protected function setUp()
    {
        $this->productVideoTable = new AmazonTable\ProductVideo(
            $this->getAdapter()
        );
        $this->productVideoIdTable = new AmazonTable\ProductVideo\ProductVideoId(
            $this->getAdapter(),
            $this->productVideoTable
        );

        $this->dropTable('product_video');
        $this->createTable('product_video');
    }

    public function testSelectCountWhereProductVideoIdLessThanOrEqualTo()
    {
        $this->assertSame(
            0,
            $this->productVideoIdTable->selectCountWhereProductVideoIdLessThanOrEqualTo(10)
        );

        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            123,
            'ASIN123',
            'Title 123',
            'Description 123',
            9999
        );
        $this->assertSame(
            1,
            $this->productVideoIdTable->selectCountWhereProductVideoIdLessThanOrEqualTo(10)
        );

        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            123,
            'ASIN123',
            'Title 123',
            'Description 123',
            9999
        );
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            456,
            'ASIN456',
            'Title 456',
            'Description 456',
            9999
        );
        $this->assertSame(
            2,
            $this->productVideoIdTable->selectCountWhereProductVideoIdLessThanOrEqualTo(10)
        );

        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            789,
            'ASIN789',
            'Title 789',
            'Description 789',
            9999
        );
        $this->assertSame(
            2,
            $this->productVideoIdTable->selectCountWhereProductVideoIdLessThanOrEqualTo(3)
        );
    }

    public function testSelectWhereProductVideoIdGreaterThanOrEqualToLimitRowCount()
    {
        $generator = $this->productVideoIdTable
            ->selectWhereProductVideoIdGreaterThanOrEqualToLimitRowCount(
                0,
                100
            );
        $this->assertCount(
            0,
            iterator_to_array($generator)
        );

        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            123,
            'ASIN123',
            'Title 123',
            'Description 123',
            9999
        );
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            456,
            'ASIN456',
            'Title 456',
            'Description 456',
            9999
        );

        $generator = $this->productVideoIdTable
            ->selectWhereProductVideoIdGreaterThanOrEqualToLimitRowCount(
                0,
                100
            );
        $array = iterator_to_array($generator);
        $this->assertCount(
            2,
            $array
        );
        $this->assertNull(
            $array[0]['browse_node.name']
        );

        $generator = $this->productVideoIdTable
            ->selectWhereProductVideoIdGreaterThanOrEqualToLimitRowCount(
                1,
                100
            );
        $this->assertCount(
            2,
            iterator_to_array($generator)
        );

        $generator = $this->productVideoIdTable
            ->selectWhereProductVideoIdGreaterThanOrEqualToLimitRowCount(
                2,
                100
            );
        $this->assertCount(
            1,
            $array = iterator_to_array($generator)
        );

        $generator = $this->productVideoIdTable
            ->selectWhereProductVideoIdGreaterThanOrEqualToLimitRowCount(
                3,
                100
            );
        $this->assertCount(
            0,
            iterator_to_array($generator)
        );

        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            789,
            'ASIN789',
            'Title 789',
            'Description 789',
            9999
        );
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            789,
            'ASIN789',
            'Title 789',
            'Description 789',
            9999
        );

        $generator = $this->productVideoIdTable
            ->selectWhereProductVideoIdGreaterThanOrEqualToLimitRowCount(
                0,
                100
            );
        $this->assertCount(
            3,
            iterator_to_array($generator)
        );

        $generator = $this->productVideoIdTable
            ->selectWhereProductVideoIdGreaterThanOrEqualToLimitRowCount(
                0,
                2
            );
        $this->assertCount(
            2,
            iterator_to_array($generator)
        );

        $generator = $this->productVideoIdTable
            ->selectWhereProductVideoIdGreaterThanOrEqualToLimitRowCount(
                3,
                2
            );
        $this->assertCount(
            1,
            iterator_to_array($generator)
        );
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
