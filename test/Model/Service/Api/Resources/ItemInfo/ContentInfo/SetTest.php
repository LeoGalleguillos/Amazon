<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\ItemInfo\ContentInfo;

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
        $this->setService = new AmazonService\Api\Resources\ItemInfo\ContentInfo\Set(
            $this->stringOrNullService
        );
    }

    public function test_getSet()
    {
        $this->assertSame(
            [
                'edition' => 'S 1TB All-Digital Edition -(Disc-free Gaming)',
            ],
            $this->setService->getSet($this->getContentInfoArray())
        );
    }

    protected function getContentInfoArray(): array
    {
        return array (
          'Edition' =>
          array (
            'DisplayValue' => 'S 1TB All-Digital Edition -(Disc-free Gaming)',
            'Label' => 'Edition',
            'Locale' => 'en_US',
          ),
          'Languages' =>
          array (
            'DisplayValues' =>
            array (
              0 =>
              array (
                'DisplayValue' => 'English',
                'Type' => 'Unknown',
              ),
            ),
            'Label' => 'Language',
            'Locale' => 'en_US',
          ),
        );
    }
}
