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
                'color'            => 'BLACK',
                'is_adult_product' => 0,
                'height_value'     => 2.8,
                'height_units'     => 'Inches',
                'length_value'     => 1.34,
                'length_units'     => 'Inches',
                'weight_value'     => 0.19,
                'weight_units'     => 'Pounds',
                'width_value'      => 2.8,
                'width_units'      => 'Inches',
                'released'         => '2019-05-22 01:00:01',
            ],
            ['product_id' => 12345]
        );
        $this->assertSame(0, $affectedRows);
        $affectedRows = $this->productTableGateway->insert(
            [
                'asin'          => 'ASIN',
                'title'         => 'Title',
                'product_group' => 'Product Group',
                'color'         => 'BLACK',
                'released'      => '2019-05-22 01:00:01',
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
