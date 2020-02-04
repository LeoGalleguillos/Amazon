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
        $this->downloadErrorsArrayToMySqlServiceMock = $this->createMock(
            AmazonService\Api\Errors\DownloadArrayToMySql::class
        );
        $this->itemArrayServiceMock = $this->createMock(
            AmazonService\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items\ItemArray::class
        );

        $this->downloadJsonToMySqlService = new AmazonService\Api\Operations\GetItems\DownloadJsonToMySql(
            $this->downloadErrorsArrayToMySqlServiceMock,
            $this->itemArrayServiceMock
        );
    }

    public function testDownloadToMySqlOneInvalidItem()
    {
        $this->downloadErrorsArrayToMySqlServiceMock
            ->expects($this->exactly(1))
            ->method('downloadArrayToMySql');

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
        $this->downloadErrorsArrayToMySqlServiceMock
            ->expects($this->exactly(0))
            ->method('downloadArrayToMySql');

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
        $this->downloadErrorsArrayToMySqlServiceMock
            ->expects($this->exactly(1))
            ->method('downloadArrayToMySql');

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
