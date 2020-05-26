<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\ItemInfo\ExternalIds\Eans;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class SaveArrayToMySqlTest extends TestCase
{
    protected function setUp(): void
    {
        $this->productEanTableMock = $this->createMock(
            AmazonTable\ProductEan::class
        );
        $this->saveArrayToMySqlService = new AmazonService\Api\Resources\ItemInfo\ExternalIds\Eans\SaveArrayToMySql(
            $this->productEanTableMock
        );
    }

    public function testSaveArrayToMySql()
    {
        $this->productEanTableMock
            ->expects($this->exactly(4))
            ->method('insertIgnore')
            ->withConsecutive(
                [12345, '3609740155567'],
                [12345, '0647684811968'],
                [12345, '5033588037965'],
                [12345, '5033588030737']
            );

        $this->saveArrayToMySqlService->saveArrayToMySql(
            $this->getExternalIdsArrayWithEans(),
            12345
        );
    }

    protected function getExternalIdsArrayWithEans(): array
    {
      return array (
        'DisplayValues' =>
        array (
          0 => '3609740155567',
          1 => '0647684811968',
          2 => '5033588037965',
          3 => '5033588030737',
        ),
        'Label' => 'EAN',
        'Locale' => 'en_US',
      );
    }
}
