<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\ItemInfo\Classifications;

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
        $this->setService = new AmazonService\Api\Resources\ItemInfo\Classifications\Set(
            $this->stringOrNullService
        );
    }

    public function testGetSet()
    {
        $this->assertSame(
            [
                'binding'       => 'Sports',
                'product_group' => 'Outdoors',
            ],
            $this->setService->getSet($this->getClassificationsArray())
        );
    }

    protected function getClassificationsArray(): array
    {
        return array (
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
        );
    }
}
