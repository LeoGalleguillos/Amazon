<?php
namespace LeoGalleguillos\AmazonTest\Model\TableGateway;

use LeoGalleguillos\Amazon\Model\TableGateway as AmazonTableGateway;
use LeoGalleguillos\Test\TableTestCase;

class ProductTest extends TableTestCase
{
    protected function setUp()
    {
        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTable('product');
        $this->setForeignKeyChecks(1);

        $this->productTableGateway = new AmazonTableGateway\Product(
            'product',
            $this->getAdapter()
        );
    }

    public function testInsertAndUpdate()
    {
        $affectedRows = $this->productTableGateway->update(
            [
                'color'            => 'RED',
                'is_adult_product' => 0,
                'height_value'     => 18.6,
                'height_units'     => 'Inches',
                'length_value'     => 187.5,
                'length_units'     => 'Inches',
                'weight_value'     => 95.0,
                'weight_units'     => 'Pounds',
                'width_value'      => 42.0,
                'width_units'      => 'Inches',
                'released'         => null,
                'size'             => null,
                'unit_count'       => 1,

                // ByLineInfo
                'brand'            => 'SUNDOLPHIN',
                'manufacturer'     => 'KL Industries',

                // ManufactureInfo
                'part_number'      => '51120',
                'model'            => 'ABCDEFG',
                'warranty'         => '1 year with full refund or replacement',

                // TradeInInfo
                'is_eligible_for_trade_in' => 1,
                'trade_in_price'           => 25.0,
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
                'is_valid'      => '1',
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
