<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\GetItems;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class JsonTest extends TestCase
{
    protected function setUp()
    {
        $configArray = require($_SERVER['PWD'] . '/config/autoload/local.php');
        $this->jsonService = new AmazonService\Api\GetItems\Json(
            $configArray['amazon']['associate_tag'],
            $configArray['amazon']['access_key_id'],
            $configArray['amazon']['secret_access_key']
        );
    }

    public function testGetXml()
    {
        $this->markTestSkipped(
            'Skip test unless you want to call Amazon Product Advertising API v5.'
        );

        $jsonString = $this->jsonService->getJson(
            [
                'B009UOMNE8',
                'B07MMZ2LTB',
                'B07D5J6Z2C'
            ],
            [
                'BrowseNodeInfo.BrowseNodes',
                'BrowseNodeInfo.BrowseNodes.Ancestor',
                'BrowseNodeInfo.BrowseNodes.SalesRank',
                'BrowseNodeInfo.WebsiteSalesRank',
            ]
        );

        $jsonArray = json_decode($jsonString, true);
        $this->assertSame(
            3,
            count($jsonArray['ItemsResult']['Items'])
        );
    }
}
