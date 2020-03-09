<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\ProductVideo;

use Exception;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;

class ProductVideoIdTest extends TableTestCase
{
    protected function setUp()
    {
        $this->productTable = new AmazonTable\Product(
            $this->getAdapter()
        );
        $this->productVideoTable = new AmazonTable\ProductVideo(
            $this->getAdapter()
        );
        $this->productVideoIdTable = new AmazonTable\ProductVideo\ProductVideoId(
            $this->getAdapter(),
            $this->productVideoTable
        );

        $this->setForeignKeyChecks0();
        $this->dropAndCreateTables(['product', 'product_video']);
        $this->setForeignKeyChecks1();
    }

    public function testSelectProductVideoIdLimitOffsetLimit1()
    {
        try {
            $this->productVideoIdTable->selectProductVideoIdLimitOffsetLimit1(10);
            $this->fail();
        } catch (Exception $exception) {
            $this->assertSame(
                'No rows found.',
                $exception->getMessage()
            );
        }

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
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            1,
            'ASIN123',
            'Title 123',
            'Description 123',
            9999
        );
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            2,
            'ASIN456',
            'Title 456',
            'Description 456',
            9999
        );

        $this->assertSame(
            1,
            $this->productVideoIdTable->selectProductVideoIdLimitOffsetLimit1(0)
        );
        $this->assertSame(
            2,
            $this->productVideoIdTable->selectProductVideoIdLimitOffsetLimit1(1)
        );
        try {
            $this->productVideoIdTable->selectProductVideoIdLimitOffsetLimit1(2);
            $this->fail();
        } catch (Exception $exception) {
            $this->assertSame(
                'No rows found.',
                $exception->getMessage()
            );
        }
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
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            1,
            'ASIN123',
            'Title 123',
            'Description 123',
            9999
        );
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            2,
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

        $this->productTable->insert(
            'asin3',
            'product title',
            'product group',
            null,
            null,
            0
        );
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            3,
            'ASIN789',
            'Title 789',
            'Description 789',
            9999
        );
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            3,
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

        $this->productTable->insert(
            'asin',
            'product title',
            'product group',
            null,
            null,
            0
        );
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            1,
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

        $this->productTable->insert(
            'asin',
            'product title',
            'product group',
            null,
            null,
            0
        );
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            1,
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
