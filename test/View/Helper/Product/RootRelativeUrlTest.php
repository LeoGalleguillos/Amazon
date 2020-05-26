<?php
namespace LeoGalleguillos\AmazonTest\View\Helper\Product;

use ArrayObject;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use PHPUnit\Framework\TestCase;

class RootRelativeUrlTest extends TestCase
{
    protected function setUp(): void
    {
        $this->productRootRelativeUrlService = $this->createMock(
            AmazonService\Product\RootRelativeUrl::class
        );
        $this->productRootRelativeUrlHelper = new AmazonHelper\Product\RootRelativeUrl(
            $this->productRootRelativeUrlService
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonHelper\Product\RootRelativeUrl::class,
            $this->productRootRelativeUrlHelper
        );
    }

    public function testInvoke()
    {
        $this->productRootRelativeUrlService->method('getRootRelativeUrl')->willReturn(
            '/products/12345/My-Product'
        );

        $this->assertSame(
            '/products/12345/My-Product',
            $this->productRootRelativeUrlHelper->__invoke(new AmazonEntity\Product())
        );
    }
}
