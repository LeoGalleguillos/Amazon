<?php
namespace LeoGalleguillos\AmazonTest\Model\TableGateway;

use LeoGalleguillos\Amazon\Model\TableGateway as AmazonTableGateway;
use LeoGalleguillos\Test\TableTestCase;

class ProductTest extends TableTestCase
{
    protected function setUp()
    {
        $this->dropAndCreateTable('product');

        $this->productTableGateway = new AmazonTableGateway\Product(
            'product',
            $this->getAdapter()
        );
    }

    public function testInsertAndUpdate()
    {
        $affectedRows = $this->productTableGateway->update(
            [
                'color' => 'BLACK',
            ],
            ['product_id' => 12345]
        );
        $this->assertSame(0, $affectedRows);
        $affectedRows = $this->productTableGateway->insert(
            [
                'asin' => 'ASIN',
                'title' => 'Title',
                'product_group' => 'Product Group',
                'color' => 'BLACK',
            ]
        );
        $this->assertSame(1, $affectedRows);
        $affectedRows = $this->productTableGateway->update(
            [
                'color' => 'RED',
            ],
            ['product_id' => 1]
        );
        $this->assertSame(1, $affectedRows);
    }
}
