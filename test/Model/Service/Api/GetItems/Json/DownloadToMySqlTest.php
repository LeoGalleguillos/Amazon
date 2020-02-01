<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\GetItems\Json;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class DownloadToMySqlTest extends TestCase
{
    protected function setUp()
    {
        $this->itemArrayServiceMock = $this->createMock(
            AmazonService\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items\ItemArray::class
        );

        $this->downloadToMySqlService = new AmazonService\Api\GetItems\Json\DownloadToMySql(
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
        $this->downloadToMySqlService->downloadToMySql($jsonString);
    }

    public function testDownloadToMySqlThreeValidItems()
    {
        $this->itemArrayServiceMock
            ->expects($this->exactly(3))
            ->method('downloadToMySql');

        $jsonString = file_get_contents(
            $_SERVER['PWD'] . '/test/data/api/get-items/three-valid-items.json'
        );
        $this->downloadToMySqlService->downloadToMySql($jsonString);
    }

    public function testDownloadToMySqlTwoInvalidAndThreeValidItems()
    {
        $this->itemArrayServiceMock
            ->expects($this->exactly(3))
            ->method('downloadToMySql');

        $jsonString = file_get_contents(
            $_SERVER['PWD'] . '/test/data/api/get-items/two-invalid-and-three-valid-items.json'
        );
        $this->downloadToMySqlService->downloadToMySql(
            $jsonString
        );
    }
}
