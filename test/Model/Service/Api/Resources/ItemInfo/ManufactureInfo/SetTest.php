<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\ItemInfo\ManufactureInfo;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use MonthlyBasis\ArrayModule\Service as ArrayModuleService;
use PHPUnit\Framework\TestCase;

class SetTest extends TestCase
{
    protected function setUp(): void
    {
        $this->stringOrNullService = new ArrayModuleService\Path\StringOrNull(
            new ArrayModuleService\Path\Exist(),
            new ArrayModuleService\Path\Value()
        );
        $this->setService = new AmazonService\Api\Resources\ItemInfo\ManufactureInfo\Set(
            $this->stringOrNullService
        );
    }

    public function testGetSet()
    {
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
