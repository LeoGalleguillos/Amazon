<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Operations\GetItems;

use LeoGalleguillos\Amazon\{
    Model\Service as AmazonService,
    Model\Table as AmazonTable
};
use PHPUnit\Framework\TestCase;

class SaveJsonToMySqlTest extends TestCase
{
    protected function setUp()
    {
        $this->asinTableMock = $this->createMock(
            AmazonTable\Product\Asin::class
        );
        $this->downloadErrorsArrayToMySqlServiceMock = $this->createMock(
            AmazonService\Api\Errors\DownloadArrayToMySql::class
        );
        $this->itemArrayServiceMock = $this->createMock(
            AmazonService\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items\ItemArray::class
        );
        $this->bannedServiceMock = $this->createMock(
            AmazonService\Product\Banned::class
        );

        $this->saveJsonToMySqlService = new AmazonService\Api\Operations\GetItems\SaveJsonToMySql(
            $this->asinTableMock,
            $this->downloadErrorsArrayToMySqlServiceMock,
            $this->itemArrayServiceMock,
            $this->bannedServiceMock
        );
    }

    public function test_saveJsonToMySql_oneInvalidItem()
    {
        $this->downloadErrorsArrayToMySqlServiceMock
            ->expects($this->exactly(1))
            ->method('downloadArrayToMySql');

        $this->asinTableMock
            ->expects($this->exactly(0))
            ->method('updateSetIsValidWhereAsin');

        $this->itemArrayServiceMock
            ->expects($this->exactly(0))
            ->method('downloadToMySql');

        $jsonString = file_get_contents(
            $_SERVER['PWD'] . '/test/data/api/get-items/one-invalid-item.json'
        );
        $this->saveJsonToMySqlService->saveJsonToMySql($jsonString);
    }

    public function test_saveJsonToMySql_threeValidItems()
    {
        $this->downloadErrorsArrayToMySqlServiceMock
            ->expects($this->exactly(0))
            ->method('downloadArrayToMySql');

        $this->asinTableMock
            ->expects($this->exactly(3))
            ->method('updateSetIsValidWhereAsin')
            ->withConsecutive(
                [1, 'B009UOMNE8'],
                [1, 'B07MMZ2LTB'],
                [1, 'B07D5J6Z2C']
            );

        $this->itemArrayServiceMock
            ->expects($this->exactly(3))
            ->method('downloadToMySql');

        $jsonString = file_get_contents(
            $_SERVER['PWD'] . '/test/data/api/get-items/three-valid-items.json'
        );
        $this->saveJsonToMySqlService->saveJsonToMySql($jsonString);
    }

    public function test_saveJsonToMySql_twoInvalidAndThreeValidItems()
    {
        $this->downloadErrorsArrayToMySqlServiceMock
            ->expects($this->exactly(1))
            ->method('downloadArrayToMySql');

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

        $this->itemArrayServiceMock
            ->expects($this->exactly(2))
            ->method('downloadToMySql');

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

        $this->downloadErrorsArrayToMySqlServiceMock
            ->expects($this->exactly(0))
            ->method('downloadArrayToMySql');
        $this->asinTableMock
            ->expects($this->exactly(2))
            ->method('updateSetIsValidWhereAsin')
            ->withConsecutive(
                [1, 'B07RF1XD36'],
                [1, 'B00YLVDJKW']
            );
        $this->itemArrayServiceMock
            ->expects($this->exactly(2))
            ->method('downloadToMySql')
            ->withConsecutive(
                [$jsonArray['ItemsResult']['Items'][0]],
                [$jsonArray['ItemsResult']['Items'][1]]
            );

        $this->saveJsonToMySqlService->saveJsonToMySql(
            $jsonString
        );
    }
}
