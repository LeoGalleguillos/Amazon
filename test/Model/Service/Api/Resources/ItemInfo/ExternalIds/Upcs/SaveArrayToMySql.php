<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\ItemInfo\ExternalIds\Upcs;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class SaveArrayToMySqlTest extends TestCase
{
    protected function setUp(): void
    {
        $this->productUpcTableMock = $this->createMock(
            AmazonTable\ProductUpc::class
        );
        $this->saveArrayToMySqlService = new AmazonService\Api\Resources\ItemInfo\ExternalIds\Upcs\SaveArrayToMySql(
            $this->productUpcTableMock
        );
    }

    public function testSaveArrayToMySql()
    {
        $this->productUpcTableMock
            ->expects($this->exactly(5))
            ->method('insertIgnore')
            ->withConsecutive(
                [12345, '102646194676'],
                [12345, '102646276990'],
                [12345, '102646155721'],
                [12345, '715663213796'],
                [12345, '763649021859']
            );

        $this->saveArrayToMySqlService->saveArrayToMySql(
            $this->getExternalIdsArrayWithUpcs(),
            12345
        );
    }

    protected function getExternalIdsArrayWithUpcs(): array
    {
      return array (
        'DisplayValues' =>
        array (
          0 => '102646194676',
          1 => '102646276990',
          2 => '102646155721',
          3 => '715663213796',
          4 => '763649021859',
        ),
        'Label' => 'UPC',
        'Locale' => 'en_US',
      );
    }
}
