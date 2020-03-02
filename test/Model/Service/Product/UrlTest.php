<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    protected function setUp()
    {
        $this->domainServiceMock = $this->createMock(
            AmazonService\Product\Domain::class
        );
        $this->rootRelativeUrlMock = $this->createMock(
            AmazonService\Product\RootRelativeUrl::class
        );
        $this->urlService = new AmazonService\Product\Url(
            $this->domainServiceMock,
            $this->rootRelativeUrlMock
        );
    }

    public function testGetUrl()
    {
        $this->domainServiceMock
            ->method('getDomain')
            ->willReturn('www.example.com');
        $this->rootRelativeUrlMock
            ->method('getRootRelativeUrl')
            ->willReturn('/products/12345/example-slug');

        $productEntity = new AmazonEntity\Product();
        $productEntity->productId = 12345;

        $this->assertSame(
            'https://www.example.com/products/12345/example-slug',
            $this->urlService->getUrl($productEntity)
        );
    }
}
