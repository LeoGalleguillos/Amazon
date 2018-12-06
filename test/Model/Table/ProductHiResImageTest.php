<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;

class ProductHiResImageTest extends TableTestCase
{
    protected function setUp()
    {
        $this->productHiResImageTable = new AmazonTable\ProductHiResImage(
            $this->getAdapter()
        );

        $this->dropTable('product_hi_res_image');
        $this->createTable('product_hi_res_image');
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonTable\ProductHiResImage::class,
            $this->productHiResImageTable
        );
    }

    public function testInsertAndSelectWhereProductId()
    {
        $generator = $this->productHiResImageTable->selectWhereProductId(1);
        $this->assertEmpty(
            iterator_to_array($generator)
        );

        $affectedRows = $this->productHiResImageTable->insert(
            1,
            'url',
            1
        );
        $this->assertSame(
            1,
            $affectedRows
        );
        $affectedRows = $this->productHiResImageTable->insert(
            1,
            'url-2',
            2
        );

        $generator = $this->productHiResImageTable->selectWhereProductId(1);
        $array = iterator_to_array($generator);

        $this->assertSame(
            2,
            count($array)
        );
    }
}
