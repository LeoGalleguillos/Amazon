<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\ItemInfo;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\TableGateway as AmazonTableGateway;
use PHPUnit\Framework\TestCase;

class DownloadArrayToMySqlTest extends TestCase
{
    protected function setUp()
    {
        $this->productTableGatewayMock = $this->createMock(
            AmazonTableGateway\Product::class
        );
        $this->downloadArrayToMySqlService = new AmazonService\Api\Resources\ItemInfo\DownloadArrayToMySql(
            $this->productTableGatewayMock
        );
    }

    public function testDownloadArrayToMySql()
    {
        $this->productTableGatewayMock
            ->expects($this->exactly(1))
            ->method('update')
            ->with(
                [
                    'color'            => 'BLACK',
                    'is_adult_product' => 0,
                ],
                ['product_id' => 12345]
            );
        $this->downloadArrayToMySqlService->downloadArrayToMySql(
            $this->getArray(),
            12345
        );
    }

    protected function getArray()
    {
        return array (
          'ByLineInfo' =>
          array (
            'Brand' =>
            array (
              'DisplayValue' => 'Blink Home Security',
              'Label' => 'Brand',
              'Locale' => 'en_US',
            ),
            'Manufacturer' =>
            array (
              'DisplayValue' => 'Immedia',
              'Label' => 'Manufacturer',
              'Locale' => 'en_US',
            ),
          ),
          'Classifications' =>
          array (
            'Binding' =>
            array (
              'DisplayValue' => 'Electronics',
              'Label' => 'Binding',
              'Locale' => 'en_US',
            ),
            'ProductGroup' =>
            array (
              'DisplayValue' => 'VDO Devices',
              'Label' => 'ProductGroup',
              'Locale' => 'en_US',
            ),
          ),
          'ExternalIds' =>
          array (
            'EANs' =>
            array (
              'DisplayValues' =>
              array (
                0 => '0841667143910',
              ),
              'Label' => 'EAN',
              'Locale' => 'en_US',
            ),
            'UPCs' =>
            array (
              'DisplayValues' =>
              array (
                0 => '841667143910',
              ),
              'Label' => 'UPC',
              'Locale' => 'en_US',
            ),
          ),
          'Features' =>
          array (
            'DisplayValues' =>
            array (
              0 => 'Extended battery life – 2 year battery life on two AA lithium batteries with a combination of two-way talk, live view, and motion recording. Double the usage of the XT on a single set of batteries when recording video.',
              1 => '2-way audio – Talk to visitors through the Blink app on your smartphone or tablet.',
              2 => 'Customizable motion detection – Use activity zones to choose where motion is detected so you receive the alerts that matter.',
              3 => 'Free cloud storage – Keep hundreds of clips stored up to a year with no monthly fees or service contract required.',
              4 => 'Works with Alexa – View live streams, motion clips, or arm and disarm your system through select Alexa-enabled devices.',
              5 => 'Day and night coverage – Record and view in up to 1080p HD video during the day and with infrared HD night vision after dark.',
              6 => 'Use indoors/outdoors – Blink XT2 stands up to the elements. Place or mount it inside or outside for whole home security.',
              7 => 'Easy setup – No tools, wiring, or professional installation required.',
            ),
            'Label' => 'Features',
            'Locale' => 'en_US',
          ),
          'ManufactureInfo' =>
          array (
            'ItemPartNumber' =>
            array (
              'DisplayValue' => '53-020304',
              'Label' => 'PartNumber',
              'Locale' => 'en_US',
            ),
            'Model' =>
            array (
              'DisplayValue' => 'BCM00200U',
              'Label' => 'Model',
              'Locale' => 'en_US',
            ),
          ),
          'ProductInfo' =>
          array (
            'Color' =>
            array (
              'DisplayValue' => 'BLACK',
              'Label' => 'Color',
              'Locale' => 'en_US',
            ),
            'IsAdultProduct' =>
            array (
              'DisplayValue' => false,
              'Label' => 'IsAdultProduct',
              'Locale' => 'en_US',
            ),
            'ItemDimensions' =>
            array (
              'Height' =>
              array (
                'DisplayValue' => 2.7999999999999998,
                'Label' => 'Height',
                'Locale' => 'en_US',
                'Unit' => 'Inches',
              ),
              'Length' =>
              array (
                'DisplayValue' => 1.3400000000000001,
                'Label' => 'Length',
                'Locale' => 'en_US',
                'Unit' => 'Inches',
              ),
              'Weight' =>
              array (
                'DisplayValue' => 0.19,
                'Label' => 'Weight',
                'Locale' => 'en_US',
                'Unit' => 'Pounds',
              ),
              'Width' =>
              array (
                'DisplayValue' => 2.7999999999999998,
                'Label' => 'Width',
                'Locale' => 'en_US',
                'Unit' => 'Inches',
              ),
            ),
            'ReleaseDate' =>
            array (
              'DisplayValue' => '2019-05-22T00:00:01Z',
              'Label' => 'ReleaseDate',
              'Locale' => 'en_US',
            ),
          ),
          'Title' =>
          array (
            'DisplayValue' => 'Blink XT2 Outdoor/Indoor Smart Security Camera with cloud storage included, 2-way audio, 2-year battery life – 1 camera kit',
            'Label' => 'Title',
            'Locale' => 'en_US',
          ),
        );
    }
}
