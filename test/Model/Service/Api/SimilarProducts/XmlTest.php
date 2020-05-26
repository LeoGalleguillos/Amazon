<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\SimilarProducts;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class XmlTest extends TestCase
{
    protected function setUp(): void
    {
        $configArray = require($_SERVER['PWD'] . '/config/autoload/local.php');
        $this->xmlService = new AmazonService\Api\SimilarProducts\Xml(
            $configArray['amazon']['access_key_id'],
            $configArray['amazon']['associate_tag'],
            $configArray['amazon']['secret_access_key']
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\Api\SimilarProducts\Xml::class,
            $this->xmlService
        );
    }

    public function testGetXml()
    {
        $this->markTestSkipped('Skip test unless you want to call Amazon.');

        $asin = 'B008FV5R2C';
        $xml  = $this->xmlService->getXml($asin);

        $this->assertInstanceOf(
            SimpleXMLElement::class,
            $xml
        );

        $this->assertInstanceOf(
            SimpleXMLElement::class,
            $xml->{'Items'}->{'Item'}
        );
    }
}
