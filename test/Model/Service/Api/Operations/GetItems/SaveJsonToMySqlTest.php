<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Operations\GetItems;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class SaveJsonToMySqlTest extends TestCase
{
    protected function setUp()
    {
        $this->asinTableMock = $this->createMock(
            AmazonTable\Product\Asin::class
        );
        $this->saveErrorsArrayToMySqlServiceMock = $this->createMock(
            AmazonService\Api\Errors\SaveArrayToMySql::class
        );
        $this->saveItemArrayToMySqlServiceMock = $this->createMock(
            AmazonService\Api\ResponseElements\Items\Item\SaveArrayToMySql::class
        );
        $this->bannedServiceMock = $this->createMock(
            AmazonService\Product\Banned::class
        );

        $this->saveJsonToMySqlService = new AmazonService\Api\Operations\GetItems\SaveJsonToMySql(
            $this->asinTableMock,
            $this->saveErrorsArrayToMySqlServiceMock,
            $this->saveItemArrayToMySqlServiceMock,
            $this->bannedServiceMock
        );
    }

    public function test_saveJsonToMySql_oneInvalidItem()
    {
        $this->saveErrorsArrayToMySqlServiceMock
            ->expects($this->exactly(1))
            ->method('saveArrayToMySql');

        $this->asinTableMock
            ->expects($this->exactly(0))
            ->method('updateSetIsValidWhereAsin');

        $this->saveItemArrayToMySqlServiceMock
            ->expects($this->exactly(0))
            ->method('saveArrayToMySql');

        $jsonString = file_get_contents(
            $_SERVER['PWD'] . '/test/data/api/get-items/one-invalid-item.json'
        );
        $this->saveJsonToMySqlService->saveJsonToMySql($jsonString);
    }

    public function test_saveJsonToMySql_threeValidItems()
    {
        $this->saveErrorsArrayToMySqlServiceMock
            ->expects($this->exactly(0))
            ->method('saveArrayToMySql');

        $this->asinTableMock
            ->expects($this->exactly(3))
            ->method('updateSetIsValidWhereAsin')
            ->withConsecutive(
                [1, 'B009UOMNE8'],
                [1, 'B07MMZ2LTB'],
                [1, 'B07D5J6Z2C']
            );

        $this->saveItemArrayToMySqlServiceMock
            ->expects($this->exactly(3))
            ->method('saveArrayToMySql');

        $jsonString = file_get_contents(
            $_SERVER['PWD'] . '/test/data/api/get-items/three-valid-items.json'
        );
        $this->saveJsonToMySqlService->saveJsonToMySql($jsonString);
    }

    public function test_saveJsonToMySql_twoInvalidAndThreeValidItems()
    {
        $this->saveErrorsArrayToMySqlServiceMock
            ->expects($this->exactly(1))
            ->method('saveArrayToMySql');

        // The first ASIN in the json file, 'B07JPLF1GD', is marked as banned.
        $this->bannedServiceMock
            ->method('isBanned')
            ->willReturnOnConsecutiveCalls(
                true,
                false,
                false
            );

        $this->asinTableMock
            ->expects($this->exactly(2))
            ->method('updateSetIsValidWhereAsin')
            ->withConsecutive(
                [1, 'B00B0PIXIK'],
                [1, 'B002LVAC5Y']
            );

        $this->saveItemArrayToMySqlServiceMock
            ->expects($this->exactly(2))
            ->method('saveArrayToMySql');

        $jsonString = file_get_contents(
            $_SERVER['PWD'] . '/test/data/api/get-items/two-invalid-and-three-valid-items.json'
        );
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
        $this->asinTableMock
            ->expects($this->exactly(2))
            ->method('updateSetIsValidWhereAsin')
            ->withConsecutive(
                [1, 'B07RF1XD36'],
                [1, 'B00YLVDJKW']
            );
        $this->saveItemArrayToMySqlServiceMock
            ->expects($this->exactly(2))
            ->method('saveArrayToMySql')
            ->withConsecutive(
                [$jsonArray['ItemsResult']['Items'][0]],
                [$jsonArray['ItemsResult']['Items'][1]]
            );

        $this->saveJsonToMySqlService->saveJsonToMySql(
            $jsonString
        );
    }
}
