<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\ItemInfo\ExternalIds\Isbns;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class SaveArrayToMySqlTest extends TestCase
{
    protected function setUp(): void
    {
        $this->productIsbnTableMock = $this->createMock(
            AmazonTable\ProductIsbn::class
        );
        $this->saveArrayToMySqlService = new AmazonService\Api\Resources\ItemInfo\ExternalIds\Isbns\SaveArrayToMySql(
            $this->productIsbnTableMock
        );
    }

    public function testSaveArrayToMySql()
    {
        $this->productIsbnTableMock
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
            $this->getExternalIdsArrayWithIsbns(),
            12345
        );
    }

    protected function getExternalIdsArrayWithIsbns(): array
    {
      return array (
        'DisplayValues' =>
        array (
          0 => '1026461946',
          1 => '1026462769',
          2 => '1026461557',
          3 => '7156632137',
        ),
        'Label' => 'ISBN',
        'Locale' => 'en_US',
      );
    }
}
