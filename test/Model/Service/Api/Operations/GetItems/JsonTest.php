<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Operations\GetItems;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class JsonTest extends TestCase
{
    protected function setUp(): void
    {
        $configArray = require($_SERVER['PWD'] . '/config/autoload/local.php');
        $this->jsonService = new AmazonService\Api\Operations\GetItems\Json(
            $configArray['amazon']['associate_tag'],
            $configArray['amazon']['access_key_id'],
            $configArray['amazon']['secret_access_key']
        );
    }

    public function testGetJson()
    {
        $this->markTestSkipped(
            'Skip test unless you want to call Amazon Product Advertising API v5.'
        );

        $jsonString = $this->jsonService->getJson(
            [
                'B01M7NSDOF',
                'B072LVZ5FX',
                'B07D5J6Z2C'
            ],
            [
                'ItemInfo.ManufactureInfo',
                'ItemInfo.ProductInfo',
            ]
        );

        $jsonArray = json_decode($jsonString, true);
        $this->assertSame(
            3,
            count($jsonArray['ItemsResult']['Items'])
        );
    }
}
