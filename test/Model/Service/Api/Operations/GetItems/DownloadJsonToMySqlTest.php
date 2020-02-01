<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Operations\GetItems;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class DownloadJsonToMySqlTest extends TestCase
{
    protected function setUp()
    {
        $this->itemArrayServiceMock = $this->createMock(
            AmazonService\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items\ItemArray::class
        );

        $this->downloadJsonToMySqlService = new AmazonService\Api\Operations\GetItems\DownloadJsonToMySql(
            $this->itemArrayServiceMock
        );
    }

    public function testDownloadToMySqlOneInvalidItem()
    {
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
