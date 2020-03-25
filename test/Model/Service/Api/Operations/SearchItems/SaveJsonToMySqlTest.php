<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Operations\SearchItems;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class SaveJsonToMySqlTest extends TestCase
{
    protected function setUp()
    {
        $this->saveItemsArrayToMySqlServiceMock = $this->createMock(
            AmazonService\Api\ResponseElements\Items\SaveArrayToMySql::class
        );

        $this->saveJsonToMySqlService = new AmazonService\Api\Operations\SearchItems\SaveJsonToMySql(
            $this->saveItemsArrayToMySqlServiceMock
        );
    }

    public function test_saveJsonToMySql_tenResults()
    {
        $jsonString = file_get_contents(
            $_SERVER['PWD'] . '/test/data/api/search-items/ten-results.json'
        );
        $jsonArray = json_decode($jsonString, true);

        $this->saveItemsArrayToMySqlServiceMock
            ->expects($this->exactly(1))
            ->method('saveArrayToMySql')
            ->with($jsonArray['SearchResult']['Items']);

        $this->saveJsonToMySqlService->saveJsonToMySql($jsonString);
    }

    public function test_saveJsonToMySql_zeroResults()
    {
        $jsonString = file_get_contents(
            $_SERVER['PWD'] . '/test/data/api/search-items/zero-results.json'
        );
        $jsonArray = json_decode($jsonString, true);

        $this->saveItemsArrayToMySqlServiceMock
            ->expects($this->exactly(0))
            ->method('saveArrayToMySql');

        $this->saveJsonToMySqlService->saveJsonToMySql($jsonString);
    }
}
