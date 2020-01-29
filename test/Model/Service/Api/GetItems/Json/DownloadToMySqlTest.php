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

    public function testDownloadToMySql()
    {
        $this->itemArrayServiceMock
            ->expects($this->exactly(3))
            ->method('downloadToMySql');

        $jsonString = file_get_contents($_SERVER['PWD'] . '/test/response.json');
        $this->downloadToMySqlService->downloadToMySql(
            $jsonString
        );

    }
}
