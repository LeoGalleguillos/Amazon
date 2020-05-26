<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Operations\SearchItems;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class JsonTest extends TestCase
{
    protected function setUp(): void
    {
        $configArray = require($_SERVER['PWD'] . '/config/autoload/local.php');
        $this->jsonService = new AmazonService\Api\Operations\SearchItems\Json(
            $configArray['amazon']['associate_tag'],
            $configArray['amazon']['access_key_id'],
            $configArray['amazon']['secret_access_key']
        );
    }

    public function testGetJson()
    {
        $this->markTestSkipped('Skip test call to Amazon PA API v5.');

        $jsonString = $this->jsonService->getJson(
            'xbox one',
            [
                'ItemInfo.ManufactureInfo',
                'ItemInfo.ProductInfo',
            ]
        );

        $jsonArray = json_decode($jsonString, true);
        $this->assertSame(
            10,
            count($jsonArray['SearchResult']['Items'])
        );
    }
}
