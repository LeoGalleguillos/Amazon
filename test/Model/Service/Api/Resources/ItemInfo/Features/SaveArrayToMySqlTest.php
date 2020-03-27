<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\ItemInfo\Features;

use Laminas\Db\Adapter\Driver\Pdo\Connection;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class SaveArrayToMySqlTest extends TestCase
{
    protected function setUp()
    {
        $this->productFeatureTableMock = $this->createMock(
            AmazonTable\ProductFeature::class
        );
        $this->connectionMock = $this->createMock(
            Connection::class
        );
        $this->saveArrayToMySqlService = new AmazonService\Api\Resources\ItemInfo\Features\SaveArrayToMySql(
            $this->productFeatureTableMock,
            $this->connectionMock
        );
    }

    public function testSaveArrayToMySql_emptyArray_0inserts()
    {
        $this->connectionMock
            ->expects($this->exactly(1))
            ->method('beginTransaction');
        $this->productFeatureTableMock
            ->expects($this->exactly(1))
            ->method('deleteWhereProductId')
            ->with(12345);
        $this->productFeatureTableMock
            ->expects($this->exactly(0))
            ->method('insert');
        $this->connectionMock
            ->expects($this->exactly(1))
            ->method('commit');

        $this->saveArrayToMySqlService->saveArrayToMySql(
            [],
            12345
        );
    }

    public function testSaveArrayToMySql_3features_2inserts()
    {
        $this->connectionMock
            ->expects($this->exactly(1))
            ->method('beginTransaction');
        $this->productFeatureTableMock
            ->expects($this->exactly(1))
            ->method('deleteWhereProductId')
            ->with(12345);
        $this->productFeatureTableMock
            ->expects($this->exactly(2))
            ->method('insert')
            ->withConsecutive(
                [12345, 'This feature should get inserted.'],
                [12345, 'This feature should also get inserted.']
            );
        $this->connectionMock
            ->expects($this->exactly(1))
            ->method('commit');

        $this->saveArrayToMySqlService->saveArrayToMySql(
            $this->getFeaturesArray(),
            12345
        );
    }

    protected function getFeaturesArray(): array
    {
        return array (
          'DisplayValues' =>
          array (
            0 => 'This feature should get inserted.',
            1 => 'This feature should be skipped because it is longer than 255 characters. Sin tantum modo ad indicia veteris memoriae cognoscenda, curiosorum. Neque enim disputari sine reprehensione nec cum iracundia aut pertinacia recte disputari potest. Nec enim figura corporis nec ratio excellens ingenii humani significat ad unam hanc rem natum hominem,',
            2 => 'This feature should also get inserted.',
          ),
          'Label' => 'Features',
          'Locale' => 'en_US',
        );
    }
}
