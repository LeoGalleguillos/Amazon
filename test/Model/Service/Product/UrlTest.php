<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\String\Model\Service as StringService;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    protected function setUp()
    {
        $this->rootRelativeUrlMock = $this->createMock(
            AmazonService\Product\RootRelativeUrl::class
        );
        $this->urlService = new AmazonService\Product\Url(
            $this->rootRelativeUrlMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\Product\Url::class,
            $this->urlService
        );
    }

    public function testGetUrl()
    {
        $productEntity = new AmazonEntity\Product();
        $productEntity->productId = 12345;
        $_SERVER['HTTP_HOST'] = 'www.example.com';
        $this->rootRelativeUrlMock->method('getRootRelativeUrl')->willReturn(
            '/products/12345/Example-slug'
        );

        $this->assertSame(
            'https://www.example.com/products/12345/Example-slug',
            $this->urlService->getUrl($productEntity)
        );
    }
}
