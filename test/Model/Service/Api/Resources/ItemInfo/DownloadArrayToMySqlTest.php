<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\ItemInfo;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class DownloadArrayToMySqlTest extends TestCase
{
    protected function setUp()
    {
        $this->downloadArrayToMySqlService = new AmazonService\Api\Resources\ItemInfo\DownloadArrayToMySql(
        );
    }

    public function testDownloadArrayToMySql()
    {
        $this->assertNull(
            $this->downloadArrayToMySqlService->downloadArrayToMySql(
                [],
                12345
            )
        );
    }
}
