<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\ItemInfo\ByLineInfo;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\ArrayModule\Service as ArrayModuleService;
use PHPUnit\Framework\TestCase;

class SetTest extends TestCase
{
    protected function setUp(): void
    {
        $this->stringOrNullService = new ArrayModuleService\Path\StringOrNull(
            new ArrayModuleService\Path\Exist(),
            new ArrayModuleService\Path\Value()
        );
        $this->setService = new AmazonService\Api\Resources\ItemInfo\ByLineInfo\Set(
            $this->stringOrNullService
        );
    }

    public function testGetSet()
    {
        $this->assertSame(
            [
                'brand'        => 'SUNDOLPHIN',
                'manufacturer' => 'KL Industries',
            ],
            $this->setService->getSet($this->getByLineInfoArray())
        );
    }

    protected function getByLineInfoArray(): array
    {
        return array (
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
        );
    }
}
