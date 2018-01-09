<?php
namespace LeoGalleguillos\AmazonTest\View\Helper\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use PHPUnit\Framework\TestCase;

class ModifiedFeatureTest extends TestCase
{
    protected function setUp()
    {
        $this->productModifiedFeatureHelper = new AmazonHelper\Product\ModifiedFeature();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonHelper\Product\ModifiedFeature::class,
            $this->productModifiedFeatureHelper
        );
    }
}
