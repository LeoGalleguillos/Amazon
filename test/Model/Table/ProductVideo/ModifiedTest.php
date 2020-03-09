<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\ProductVideo;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;

class ModifiedTest extends TableTestCase
{
    protected function setUp()
    {
        $this->productTable = new AmazonTable\Product(
            $this->getAdapter()
        );
        $this->productVideoTable = new AmazonTable\ProductVideo(
            $this->getAdapter()
        );
        $this->modifiedTable = new AmazonTable\ProductVideo\Modified(
            $this->getAdapter(),
            $this->productVideoTable
        );

        $this->setForeignKeyChecks0();
        $this->dropAndCreateTables(['browse_node_product', 'product', 'product_video']);
        $this->setForeignKeyChecks1();
    }

    public function testSelectWhereModifiedIsNullAndBrowseNodeIdIsNullLimit()
    {
        $generator = $this->modifiedTable->selectWhereModifiedIsNullAndBrowseNodeIdIsNullLimit(
            10
        );
        $array = iterator_to_array($generator);
        $this->assertEmpty($array);

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
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            1,
            'ASIN1',
            'Title',
            'Description',
            12345
        );
        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            3,
            'ASIN3',
            'Title',
            'Description',
            67890
        );

        $generator = $this->modifiedTable->selectWhereModifiedIsNullAndBrowseNodeIdIsNullLimit(
            10
        );
        $array = iterator_to_array($generator);
        $this->assertCount(
            2,
            $array
        );
    }
}
