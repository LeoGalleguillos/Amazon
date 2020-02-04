<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Errors;

use LeoGalleguillos\Amazon\{
    Model\Service as AmazonService,
    Model\Table as AmazonTable
};
use PHPUnit\Framework\TestCase;

class DownloadArrayToMySqlTest extends TestCase
{
    protected function setUp()
    {
        $this->asinTableMock = $this->createMock(
            AmazonTable\Product\Asin::class
        );

        $this->downloadArrayToMySqlService = new AmazonService\Api\Errors\DownloadArrayToMySql(
            $this->asinTableMock
        );
    }

    public function testDownloadJsonToMySql()
    {
        $this->asinTableMock
            ->expects($this->exactly(2))
            ->method('updateSetInvalidWhereAsin')
            ->withConsecutive(
                [0, 'B00388Q3WU'],
                [0, 'B071K8P186']
            );

        $this->downloadArrayToMySqlService->downloadArrayToMySql(
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
        );
    }
}
