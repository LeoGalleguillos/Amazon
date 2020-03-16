<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Operations\GetItems;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class GetJsonAndSaveJsonToMySqlTest extends TestCase
{
    protected function setUp()
    {
        $this->jsonServiceMock = $this->createMock(
            AmazonService\Api\Operations\GetItems\Json::class
        );
        $this->saveJsonToMySqlServiceMock = $this->createMock(
            AmazonService\Api\Operations\GetItems\SaveJsonToMySql::class
        );

        $this->getJsonAndSaveJsonToMySqlService = new AmazonService\Api\Operations\GetItems\GetJsonAndSaveJsonToMySql(
            $this->jsonServiceMock,
            $this->saveJsonToMySqlServiceMock
        );
    }

    public function testGetJsonAndSaveJsonToMySql()
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

        $this->getJsonAndSaveJsonToMySqlService->getJsonAndSaveJsonToMySql(
            $itemIds,
            $resources
        );
    }
}
