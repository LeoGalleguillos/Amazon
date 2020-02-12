<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\ItemInfo\ProductInfo\Size\DisplayValue;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class StringOrNullTest extends TestCase
{
    protected function setUp()
    {
        $this->stringOrNullService = new AmazonService\Api\Resources\ItemInfo\ProductInfo\Size\DisplayValue\StringOrNull();
    }

    public function testGetStringOrNull()
    {
        $itemInfoArray = array();

        $this->assertSame(
            null,
            $this->stringOrNullService->getStringOrNull($itemInfoArray)
        );

        $itemInfoArray = array(
          'ProductInfo' =>
          array (
            'ReleaseDate' =>
            array (
              'DisplayValue' => '2019-05-22T01:00:01Z',
              'Label' => 'ReleaseDate',
              'Locale' => 'en_US',
            ),
          ),
        );

        $this->assertSame(
            null,
            $this->stringOrNullService->getStringOrNull($itemInfoArray)
        );

        $itemInfoArray = array(
          'ProductInfo' =>
          array (
            'Size' =>
            array (
              'DisplayValue' => 'Medium',
              'Label' => 'Size',
              'Locale' => 'en_US',
            ),
            'ReleaseDate' =>
            array (
              'DisplayValue' => '2019-05-22T01:00:01Z',
              'Label' => 'ReleaseDate',
              'Locale' => 'en_US',
            ),
          ),
        );

        $this->assertSame(
            'Medium',
            $this->stringOrNullService->getStringOrNull($itemInfoArray)
        );

        $stringOfLength127 = 'Fx1p3Qa6qAoPPU924sxLDPgPMontRmBymotlVhgEPgHP0vURnbkWxusaHRC3CiQ9lKESuswvAEMXhMkqxUDN0e1XD1uEBSe6Vt620fOmoF5cNqNiKX0Kv73f5vHCP57';
        $itemInfoArray = array(
          'ProductInfo' =>
          array (
            'Size' =>
            array (
              'DisplayValue' => $stringOfLength127,
              'Label' => 'Size',
              'Locale' => 'en_US',
            ),
          ),
        );

        $this->assertSame(
            $stringOfLength127,
            $this->stringOrNullService->getStringOrNull($itemInfoArray)
        );

        $stringOfLength128 = 'ls25egCggnbS2vHEjr4nssfmjdiekhXAwSVvxaIw3uAuD3JMhgHUJjMukoNxyiPmgn4Ct1ZiHnziaQ9HotJBceF1BicwzDceKnOtnu1ugleVnbXLY4Kl7H2zHK4WTnC6';
        $itemInfoArray = array(
          'ProductInfo' =>
          array (
            'Size' =>
            array (
              'DisplayValue' => $stringOfLength128,
              'Label' => 'Size',
              'Locale' => 'en_US',
            ),
          ),
        );

        $this->assertSame(
            null,
            $this->stringOrNullService->getStringOrNull($itemInfoArray)
        );
    }
}
