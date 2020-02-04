<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Operations\GetItems;

use LeoGalleguillos\Amazon\{
    Model\Service as AmazonService,
    Model\Table as AmazonTable
};
use PHPUnit\Framework\TestCase;

class DownloadJsonToMySqlTest extends TestCase
{
    protected function setUp()
    {
        $this->itemArrayServiceMock = $this->createMock(
            AmazonService\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items\ItemArray::class
        );
        $this->asinTableMock = $this->createMock(
            AmazonTable\Product\Asin::class
        );

        $this->downloadJsonToMySqlService = new AmazonService\Api\Operations\GetItems\DownloadJsonToMySql(
            $this->itemArrayServiceMock,
            $this->asinTableMock
        );
    }

    public function testDownloadToMySqlOneInvalidItem()
    {
        $this->asinTableMock
            ->expects($this->exactly(1))
            ->method('updateSetInvalidWhereAsin')
            ->with(0, 'B01MF9L9V3');

        $this->itemArrayServiceMock
            ->expects($this->exactly(0))
            ->method('downloadToMySql');

        $jsonString = file_get_contents(
            $_SERVER['PWD'] . '/test/data/api/get-items/one-invalid-item.json'
        );
        $this->downloadJsonToMySqlService->downloadJsonToMySql($jsonString);
    }

    public function testDownloadToMySqlThreeValidItems()
    {
        $this->asinTableMock
            ->expects($this->exactly(0))
            ->method('updateSetInvalidWhereAsin');

        $this->itemArrayServiceMock
            ->expects($this->exactly(3))
            ->method('downloadToMySql');

        $jsonString = file_get_contents(
            $_SERVER['PWD'] . '/test/data/api/get-items/three-valid-items.json'
        );
        $this->downloadJsonToMySqlService->downloadJsonToMySql($jsonString);
    }

    public function testDownloadToMySqlTwoInvalidAndThreeValidItems()
    {
        $this->asinTableMock
            ->expects($this->exactly(2))
            ->method('updateSetInvalidWhereAsin')
            ->withConsecutive(
                [0, 'B00388Q3WU'],
                [0, 'B071K8P186']
            );

        $this->itemArrayServiceMock
            ->expects($this->exactly(3))
            ->method('downloadToMySql');

        $jsonString = file_get_contents(
            $_SERVER['PWD'] . '/test/data/api/get-items/two-invalid-and-three-valid-items.json'
        );
        $this->downloadJsonToMySqlService->downloadJsonToMySql(
            $jsonString
        );
    }
}
