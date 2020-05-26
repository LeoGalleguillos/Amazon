<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Operations\GetItems;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class SaveJsonToMySqlTest extends TestCase
{
    protected function setUp(): void
    {
        $this->saveErrorsArrayToMySqlServiceMock = $this->createMock(
            AmazonService\Api\Errors\SaveArrayToMySql::class
        );
        $this->saveItemsArrayToMySqlServiceMock = $this->createMock(
            AmazonService\Api\ResponseElements\Items\SaveArrayToMySql::class
        );

        $this->saveJsonToMySqlService = new AmazonService\Api\Operations\GetItems\SaveJsonToMySql(
            $this->saveErrorsArrayToMySqlServiceMock,
            $this->saveItemsArrayToMySqlServiceMock
        );
    }

    public function test_saveJsonToMySql_oneInvalidItem()
    {
        $jsonString = file_get_contents(
            $_SERVER['PWD'] . '/test/data/api/get-items/one-invalid-item.json'
        );
        $jsonArray = json_decode($jsonString, true);

        $this->saveErrorsArrayToMySqlServiceMock
            ->expects($this->exactly(1))
            ->method('saveArrayToMySql')
            ->with($jsonArray['Errors']);
        $this->saveItemsArrayToMySqlServiceMock
            ->expects($this->exactly(0))
            ->method('saveArrayToMySql');

        $this->saveJsonToMySqlService->saveJsonToMySql($jsonString);
    }

    public function test_saveJsonToMySql_oneValidItem()
    {
        $jsonString = file_get_contents(
            $_SERVER['PWD'] . '/test/data/api/get-items/one-valid-item.json'
        );
        $jsonArray = json_decode($jsonString, true);

        $this->saveErrorsArrayToMySqlServiceMock
            ->expects($this->exactly(0))
            ->method('saveArrayToMySql');
        $this->saveItemsArrayToMySqlServiceMock
            ->expects($this->exactly(1))
            ->method('saveArrayToMySql')
            ->with($jsonArray['ItemsResult']['Items']);

        $this->saveJsonToMySqlService->saveJsonToMySql($jsonString);
    }

    public function test_saveJsonToMySql_threeValidItems()
    {
        $jsonString = file_get_contents(
            $_SERVER['PWD'] . '/test/data/api/get-items/three-valid-items.json'
        );
        $jsonArray = json_decode($jsonString, true);

        $this->saveErrorsArrayToMySqlServiceMock
            ->expects($this->exactly(0))
            ->method('saveArrayToMySql');
        $this->saveItemsArrayToMySqlServiceMock
            ->expects($this->exactly(1))
            ->method('saveArrayToMySql')
            ->with($jsonArray['ItemsResult']['Items']);

        $this->saveJsonToMySqlService->saveJsonToMySql($jsonString);
    }

    public function test_saveJsonToMySql_twoInvalidAndThreeValidItems()
    {
        $jsonString = file_get_contents(
            $_SERVER['PWD'] . '/test/data/api/get-items/two-invalid-and-three-valid-items.json'
        );
        $jsonArray = json_decode($jsonString, true);

        $this->saveErrorsArrayToMySqlServiceMock
            ->expects($this->exactly(1))
            ->method('saveArrayToMySql')
            ->with($jsonArray['Errors']);
        $this->saveItemsArrayToMySqlServiceMock
            ->expects($this->exactly(1))
            ->method('saveArrayToMySql')
            ->with($jsonArray['ItemsResult']['Items']);

        $this->saveJsonToMySqlService->saveJsonToMySql(
            $jsonString
        );
    }

    public function test_saveJsonToMySql_images()
    {
        $jsonString = file_get_contents(
            $_SERVER['PWD'] . '/test/data/api/get-items/images.json'
        );
        $jsonArray = json_decode($jsonString, true);

        $this->saveErrorsArrayToMySqlServiceMock
            ->expects($this->exactly(0))
            ->method('saveArrayToMySql');
        $this->saveItemsArrayToMySqlServiceMock
            ->expects($this->exactly(1))
            ->method('saveArrayToMySql')
            ->with($jsonArray['ItemsResult']['Items']);

        $this->saveJsonToMySqlService->saveJsonToMySql(
            $jsonString
        );
    }
}
