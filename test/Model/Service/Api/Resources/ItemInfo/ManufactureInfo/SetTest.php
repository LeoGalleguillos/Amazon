<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\ItemInfo\ManufactureInfo;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class SetTest extends TestCase
{
    protected function setUp()
    {
        $this->warrantyStringOrNullServiceMock = $this->createMock(
            AmazonService\Api\Resources\ItemInfo\ManufactureInfo\Warranty\DisplayValue\StringOrNull::class
        );
        $this->setService = new AmazonService\Api\Resources\ItemInfo\ManufactureInfo\Set(
            $this->warrantyStringOrNullServiceMock
        );
    }

    public function testGetSet()
    {
        $this->warrantyStringOrNullServiceMock
            ->method('getStringOrNull')
            ->will(
                $this->returnValue('1 year with full refund or replacement')
            );
        $this->assertSame(
            [
                'part_number' => '51120',
                'model'       => 'ABCDEFG',
                'warranty'    => '1 year with full refund or replacement',
            ],
            $this->setService->getSet($this->getManufactureInfoArray())
        );
    }

    protected function getManufactureInfoArray(): array
    {
        return array (
          'ItemPartNumber' =>
          array (
            'DisplayValue' => '51120',
            'Label' => 'PartNumber',
            'Locale' => 'en_US',
          ),
          'Model' =>
          array (
            'DisplayValue' => 'ABCDEFG',
            'Label' => 'Model',
            'Locale' => 'en_US',
          ),
          'Warranty' =>
          array (
            'DisplayValue' => '1 year with full refund or replacement',
            'Label' => 'Model',
            'Locale' => 'en_US',
          ),
        );
    }
}
