<?php
namespace LeoGalleguillos\AmazonTest\View\Helper\Product;

use ArrayObject;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use PHPUnit\Framework\TestCase;

class AffiliateUrlTest extends TestCase
{
    protected function setUp()
    {
        $this->affiliateUrlHelper = new AmazonHelper\Product\AffiliateUrl();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonHelper\Product\AffiliateUrl::class,
            $this->affiliateUrlHelper
        );
    }

    public function testInvoke()
    {
        $productEntity       = new AmazonEntity\Product();
        $productEntity->asin = 'MYASIN123';
        $tag                 = 'my-tag-20';

        $this->assertSame(
            'https://www.amazon.com/gp/product/MYASIN123?tag=my-tag-20',
            $this->affiliateUrlHelper->__invoke($productEntity, $tag)
        );
    }
}
