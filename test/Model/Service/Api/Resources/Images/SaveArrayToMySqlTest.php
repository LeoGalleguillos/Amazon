<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\Images;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class SaveArrayToMySqlTest extends TestCase
{
    protected function setUp()
    {
        $this->saveArrayToMySqlService = new AmazonService\Api\Resources\Images\SaveArrayToMySql(
        );
    }

    public function test_saveArrayToMySql()
    {
        $this->assertNull(
            $this->saveArrayToMySqlService->saveArrayToMySql([], 1)
        );
    }
}
