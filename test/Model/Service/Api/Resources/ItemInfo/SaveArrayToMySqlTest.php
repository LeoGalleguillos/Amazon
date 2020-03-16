<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\ItemInfo;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\TableGateway as AmazonTableGateway;
use LeoGalleguillos\ArrayModule\Service as ArrayModuleService;
use PHPUnit\Framework\TestCase;

class SaveArrayToMySqlTest extends TestCase
{
    protected function setUp()
    {
        $this->byLineInfoSetServiceMock = $this->createMock(
            AmazonService\Api\Resources\ItemInfo\ByLineInfo\Set::class
        );
        $this->classificationsSetServiceMock = $this->createMock(
            AmazonService\Api\Resources\ItemInfo\Classifications\Set::class
        );
        $this->saveExternalIdsArrayToMySqlMock = $this->createMock(
            AmazonService\Api\Resources\ItemInfo\ExternalIds\SaveArrayToMySql::class
        );
        $this->manufactureInfoSetServiceMock = $this->createMock(
            AmazonService\Api\Resources\ItemInfo\ManufactureInfo\Set::class
        );
        $this->productTableGatewayMock = $this->createMock(
            AmazonTableGateway\Product::class
        );
        $this->stringOrNullServiceMock = $this->createMock(
            ArrayModuleService\Path\StringOrNull::class
        );
        $this->saveArrayToMySqlService = new AmazonService\Api\Resources\ItemInfo\SaveArrayToMySql(
            $this->byLineInfoSetServiceMock,
            $this->classificationsSetServiceMock,
            $this->saveExternalIdsArrayToMySqlMock,
            $this->manufactureInfoSetServiceMock,
            $this->productTableGatewayMock,
            $this->stringOrNullServiceMock
        );
    }

    public function test_saveArrayToMySql()
    {
        $this->byLineInfoSetServiceMock
            ->expects($this->exactly(1))
            ->method('getSet')
            ->with(
                $this->identicalTo(
                    $this->getArray()['ByLineInfo']
                )
            )
            ->willReturn([
                'brand'        => 'SUNDOLPHIN',
                'manufacturer' => 'KL Industries',
            ]);
        $this->classificationsSetServiceMock
            ->expects($this->exactly(1))
            ->method('getSet')
            ->with(
                $this->identicalTo(
                    $this->getArray()['Classifications']
                )
            )
            ->willReturn([
                'binding'       => 'Sports',
                'product_group' => 'Outdoors',
            ]);
        $this->manufactureInfoSetServiceMock
            ->expects($this->exactly(1))
            ->method('getSet')
            ->with(
                $this->identicalTo(
                    $this->getArray()['ManufactureInfo']
                )
            )
            ->willReturn([
                'part_number' => '51120',
                'model'       => 'ABCDEFG',
                'warranty'    => '1 year with full refund or replacement',
            ]);
        $this->stringOrNullServiceMock
            ->method('getStringOrNull')
            ->will(
                $this->onConsecutiveCalls(
                    'RED',
                    null
                )
            );

        $this->productTableGatewayMock
            ->expects($this->exactly(1))
            ->method('update')
            ->with(
                // Use identicalTo to ensure 0 xor null
                $this->identicalTo(
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

                        // Classifications
                        'binding'          => 'Sports',
                        'product_group'    => 'Outdoors',

                        // ManufactureInfo
                        'part_number'      => '51120',
                        'model'            => 'ABCDEFG',
                        'warranty'         => '1 year with full refund or replacement',
                    ],
                    ['product_id' => 12345]
                )
            );
        $this->saveExternalIdsArrayToMySqlMock
            ->expects($this->exactly(1))
            ->method('saveArrayToMySql')
            ->with(
                $this->identicalTo(
                    $this->getArray()['ExternalIds']
                )
            );

        $this->saveArrayToMySqlService->saveArrayToMySql(
            $this->getArray(),
            12345
        );
    }

    protected function getArray(): array
    {
      return array (
        'ByLineInfo' =>
        array (
          'Brand' =>
          array (
            'DisplayValue' => 'SUNDOLPHIN',
            'Label' => 'Brand',
            'Locale' => 'en_US',
          ),
          'Manufacturer' =>
          array (
            'DisplayValue' => 'KL Industries',
            'Label' => 'Manufacturer',
            'Locale' => 'en_US',
          ),
        ),
        'Classifications' =>
        array (
          'Binding' =>
          array (
            'DisplayValue' => 'Sports',
            'Label' => 'Binding',
            'Locale' => 'en_US',
          ),
          'ProductGroup' =>
          array (
            'DisplayValue' => 'Outdoors',
            'Label' => 'ProductGroup',
            'Locale' => 'en_US',
          ),
        ),
        'ExternalIds' =>
        array (
          'EANs' =>
          array (
            'DisplayValues' =>
            array (
              0 => '3609740155567',
              1 => '0647684811968',
              2 => '5033588037965',
              3 => '5033588030737',
            ),
            'Label' => 'EAN',
            'Locale' => 'en_US',
          ),
          'UPCs' =>
          array (
            'DisplayValues' =>
            array (
              0 => '019862511203',
            ),
            'Label' => 'UPC',
            'Locale' => 'en_US',
          ),
        ),
        'Features' =>
        array (
          'DisplayValues' =>
          array (
            0 => 'Ideal family recreational canoe with comfortable seating for three',
            1 => 'Storage compartment and cooler under center seat',
            2 => 'Bow and stern tie-down eyelets and built-in transport handles',
            3 => 'Drink holders molded into every seat',
            4 => 'Includes limited two-year manufacturer\'s warranty',
          ),
          'Label' => 'Features',
          'Locale' => 'en_US',
        ),
        'ManufactureInfo' =>
        array (
          'ItemPartNumber' =>
          array (
            'DisplayValue' => '51120',
            'Label' => 'PartNumber',
            'Locale' => 'en_US',
          ),
          'Model' =>
          array (
            'DisplayValue' => '51120',
            'Label' => 'Model',
            'Locale' => 'en_US',
          ),
        ),
        'ProductInfo' =>
        array (
          'Color' =>
          array (
            'DisplayValue' => 'Green',
            'Label' => 'Color',
            'Locale' => 'en_US',
          ),
          'IsAdultProduct' =>
          array (
            'DisplayValue' => false,
            'Label' => 'IsAdultProduct',
            'Locale' => 'en_US',
          ),
          'ItemDimensions' =>
          array (
            'Height' =>
            array (
              'DisplayValue' => 18.6,
              'Label' => 'Height',
              'Locale' => 'en_US',
              'Unit' => 'Inches',
            ),
            'Length' =>
            array (
              'DisplayValue' => 187.5,
              'Label' => 'Length',
              'Locale' => 'en_US',
              'Unit' => 'Inches',
            ),
            'Weight' =>
            array (
              'DisplayValue' => 95,
              'Label' => 'Weight',
              'Locale' => 'en_US',
              'Unit' => 'Pounds',
            ),
            'Width' =>
            array (
              'DisplayValue' => 42,
              'Label' => 'Width',
              'Locale' => 'en_US',
              'Unit' => 'Inches',
            ),
          ),
          'Size' =>
          array (
            'DisplayValue' => '15.6\'',
            'Label' => 'Size',
            'Locale' => 'en_US',
          ),
          'UnitCount' =>
          array (
            'DisplayValue' => 1,
            'Label' => 'NumberOfItems',
            'Locale' => 'en_US',
          ),
        ),
        'Title' =>
        array (
          'DisplayValue' => 'SUNDOLPHIN Sun Dolphin Mackinaw Canoe (Green, 15.6-Feet)',
          'Label' => 'Title',
          'Locale' => 'en_US',
        ),
      );
    }
}
