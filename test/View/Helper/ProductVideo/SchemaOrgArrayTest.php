<?php
namespace LeoGalleguillos\AmazonTest\View\Helper\Product;

use DateTime;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use PHPUnit\Framework\TestCase;

class SchemaOrgArrayTest extends TestCase
{
    protected function setUp()
    {
        $this->slugServiceMock = $this->createMock(
            AmazonService\Product\Slug::class
        );

        $this->schemaOrgArrayHelper = new AmazonHelper\ProductVideo\SchemaOrgArray(
            $this->slugServiceMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonHelper\ProductVideo\SchemaOrgArray::class,
            $this->schemaOrgArrayHelper
        );
    }

    public function testInvoke()
    {
        $productEntity = new AmazonEntity\Product();
        $productEntity->setAsin('LEO12345')
            ->setTitle('Product Title');

        $productVideoEntity = new AmazonEntity\ProductVideo();
        $productVideoEntity->setCreated(new DateTime('2018-12-18 12:34:56'))
                           ->setDurationMilliseconds(12345)
                           ->setProduct($productEntity);

        $array = $this->schemaOrgArrayHelper->__invoke($productVideoEntity);
        $this->assertInternalType(
            'array',
            $array
        );
    }
}
