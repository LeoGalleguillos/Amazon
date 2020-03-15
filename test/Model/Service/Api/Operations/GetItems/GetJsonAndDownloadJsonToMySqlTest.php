<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Operations\GetItems;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class GetJsonAndDownloadJsonToMySqlTest extends TestCase
{
    protected function setUp()
    {
        $this->jsonServiceMock = $this->createMock(
            AmazonService\Api\Operations\GetItems\Json::class
        );
        $this->saveJsonToMySqlServiceMock = $this->createMock(
            AmazonService\Api\Operations\GetItems\SaveJsonToMySql::class
        );

        $this->getJsonAndDownloadJsonToMySqlService = new AmazonService\Api\Operations\GetItems\GetJsonAndDownloadJsonToMySql(
            $this->jsonServiceMock,
            $this->saveJsonToMySqlServiceMock
        );
    }

    public function testGetJsonAndDownloadJsonToMySql()
    {
        $itemIds    = [];
        $resources  = [];
        $jsonString = '{ "foo":"bar" }';

        $this->jsonServiceMock
            ->expects($this->exactly(1))
            ->method('getJson')
            ->with($itemIds, $resources)
            ->will(
                $this->returnValue($jsonString)
            );
        $this->saveJsonToMySqlServiceMock
            ->expects($this->exactly(1))
            ->method('saveJsonToMySql')
            ->with($jsonString);

        $this->getJsonAndDownloadJsonToMySqlService->getJsonAndDownloadJsonToMySql(
            $itemIds,
            $resources
        );
    }
}
