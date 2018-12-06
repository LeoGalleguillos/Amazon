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
}
