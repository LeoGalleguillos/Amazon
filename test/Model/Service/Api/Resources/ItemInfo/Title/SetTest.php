<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\ItemInfo\Title;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\ArrayModule\Service as ArrayModuleService;
use PHPUnit\Framework\TestCase;

class SetTest extends TestCase
{
    protected function setUp()
    {
        $this->stringOrNullService = new ArrayModuleService\Path\StringOrNull(
            new ArrayModuleService\Path\Exist(),
            new ArrayModuleService\Path\Value()
        );
        $this->setService = new AmazonService\Api\Resources\ItemInfo\Title\Set(
            $this->stringOrNullService
        );
    }

    public function testGetSet()
    {
        $this->assertSame(
            [
                'title' => 'SUNDOLPHIN Sun Dolphin Mackinaw Canoe (Green, 15.6-Feet)',
            ],
            $this->setService->getSet($this->getTitleArray())
        );
    }

    protected function getTitleArray(): array
    {
        return array (
          'DisplayValue' => 'SUNDOLPHIN Sun Dolphin Mackinaw Canoe (Green, 15.6-Feet)',
          'Label' => 'Title',
          'Locale' => 'en_US',
        );
    }
}
