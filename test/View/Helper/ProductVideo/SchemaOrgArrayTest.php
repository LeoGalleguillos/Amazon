<?php
namespace LeoGalleguillos\AmazonTest\View\Helper\Product;

use DateTime;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use LeoGalleguillos\String\Model\Service as StringService;
use PHPUnit\Framework\TestCase;

class SchemaOrgArrayTest extends TestCase
{
    protected function setUp()
    {
        $this->schemaOrgArrayHelper = new AmazonHelper\ProductVideo\SchemaOrgArray(
            new StringService\UrlFriendly()
        );
    }

    public function testInvoke()
    {
        $productVideoEntity = new AmazonEntity\ProductVideo();
        $productVideoEntity
            ->setAsin('LEO12345')
            ->setCreated(new DateTime('2018-12-18 12:34:56'))
            ->setDurationMilliseconds(12345)
            ->setTitle('My Amazin Product Video')
            ;

        $array = $this->schemaOrgArrayHelper->__invoke($productVideoEntity);
        $this->assertInternalType(
            'array',
            $array
        );
    }
}
