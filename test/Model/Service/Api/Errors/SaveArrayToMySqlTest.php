<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Errors;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class SaveArrayToMySqlTest extends TestCase
{
    protected function setUp(): void
    {
        $this->asinTableMock = $this->createMock(
            AmazonTable\Product\Asin::class
        );

        $this->saveArrayToMySqlService = new AmazonService\Api\Errors\SaveArrayToMySql(
            $this->asinTableMock
        );
    }

    public function test_saveArrayToMySql()
    {
        $this->asinTableMock
            ->expects($this->exactly(3))
            ->method('updateSetModifiedToUtcTimestampWhereAsin')
            ->withConsecutive(
                ['B00388Q3WU'],
                ['B071K8P186'],
                ['B072QTHMC7']
            );
        $this->asinTableMock
            ->expects($this->exactly(3))
            ->method('updateSetIsValidWhereAsin')
            ->withConsecutive(
                [0, 'B00388Q3WU'],
                [0, 'B071K8P186'],
                [0, 'B072QTHMC7']
            );

        $this->saveArrayToMySqlService->saveArrayToMySql(
            $this->getErrorsArray()
        );
    }

    protected function getErrorsArray()
    {
        return array (
          0 =>
          array (
            '__type' => 'com.amazon.paapi5#ErrorData',
            'Code' => 'InvalidParameterValue',
            'Message' => 'The ItemId B00388Q3WU provided in the request is invalid.',
          ),
          1 =>
          array (
            '__type' => 'com.amazon.paapi5#ErrorData',
            'Code' => 'InvalidParameterValue',
            'Message' => 'The ItemId B071K8P186 provided in the request is invalid.',
          ),
          2 =>
          array (
            '__type' => 'com.amazon.paapi5#ErrorData',
            'Code' => 'ItemNotAccessible',
            'Message' => 'The ItemId B072QTHMC7 is not accessible through the Product Advertising API.',
          ),
        );
    }
}
