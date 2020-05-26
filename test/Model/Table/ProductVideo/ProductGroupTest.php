<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\ProductVideo;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;

class ProductGroupTest extends TableTestCase
{
    protected function setUp(): void
    {
        $this->SetForeignKeyChecks(0);
        $this->dropAndCreateTables(['product', 'product_video']);
        $this->SetForeignKeyChecks(1);

        $this->productTable = new AmazonTable\Product(
            $this->getAdapter()
        );
        $this->productVideoTable = new AmazonTable\ProductVideo(
            $this->getAdapter()
        );
        $this->productGroupTable = new AmazonTable\ProductVideo\ProductGroup(
            $this->getAdapter(),
            $this->productVideoTable
        );
    }

    public function testSelectWhereProductGroup()
    {
        $productId1 = $this->productTable->insert(
            'ASIN1',
            'Title',
            'Book',
            null,
            null,
            0.00
        );
        $productId2 = $this->productTable->insert(
            'ASIN2',
            'Title',
            'Music',
            null,
            null,
            0.00
        );
        $productId3 = $this->productTable->insert(
            'ASIN3',
            'Title',
            'Movie',
            null,
            null,
            0.00
        );
        $productId4 = $this->productTable->insert(
            'ASIN4',
            'Title',
            'Music',
            null,
            null,
            0.00
        );
        $productId5 = $this->productTable->insert(
            'ASIN5',
            'Title',
            'Music',
            null,
            null,
            0.00
        );
        $productId6 = $this->productTable->insert(
            'ASIN6',
            'Title',
            'DVD',
            null,
            null,
            0.00
        );

        // Music
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            $productId2,
            'ASIN2',
            'Title',
            'Description',
            1000
        );

        // Movie
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            $productId3,
            'ASIN3',
            'Title',
            'Description',
            1000
        );

        // Music
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            $productId5,
            'ASIN5',
            'Title',
            'Description',
            1000
        );

        // DVD
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            $productId6,
            'ASIN6',
            'Title',
            'Description',
            1000
        );

        // In neither table
        $generator = $this->productGroupTable->selectWhereProductGroup('Apparel');
        $this->assertEmpty(iterator_to_array($generator));

        // In product table but not in product_video table
        $generator = $this->productGroupTable->selectWhereProductGroup('Book');
        $this->assertEmpty(iterator_to_array($generator));

        $generator = $this->productGroupTable->selectWhereProductGroup('Music');
        $array = iterator_to_array($generator);
        $this->assertCount(
            2,
            $array
        );
        $this->assertSame(
            $array[0]['asin'],
            'ASIN2'
        );
        $this->assertSame(
            $array[1]['asin'],
            'ASIN5'
        );

        $generator = $this->productGroupTable->selectWhereProductGroup('DVD');
        $array = iterator_to_array($generator);
        $this->assertCount(
            1,
            $array
        );
        $this->assertSame(
            $array[0]['asin'],
            'ASIN6'
        );
    }
}
