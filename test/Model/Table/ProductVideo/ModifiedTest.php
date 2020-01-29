<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\ProductVideo;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;

class ModifiedTest extends TableTestCase
{
    protected function setUp()
    {
        $this->productVideoTable = new AmazonTable\ProductVideo(
            $this->getAdapter()
        );

        $this->modifiedTable = new AmazonTable\ProductVideo\Modified(
            $this->getAdapter(),
            $this->productVideoTable
        );

        $this->dropTable('product_video');
        $this->createTable('product_video');
    }

    public function testSelectWhereModifiedIsNullAndBrowseNodeIdIsNullLimit()
    {
        $generator = $this->modifiedTable->selectWhereModifiedIsNullAndBrowseNodeIdIsNullLimit(
            10
        );
        $array = iterator_to_array($generator);
        $this->assertEmpty($array);

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
