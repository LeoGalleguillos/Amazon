<?php
namespace LeoGalleguillos\AmazonTest\Model\Service;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use MonthlyBasis\String\Model\Service as StringService;
use PHPUnit\Framework\TestCase;

class RootRelativeUrlTest extends TestCase
{
    protected function setUp(): void
    {
        $this->modifiedTitleServiceMock = $this->createMock(
            AmazonService\Product\ModifiedTitle::class
        );
        $this->urlFriendlyServiceMock   = $this->createMock(
            StringService\UrlFriendly::class
        );
        $this->rootRelativeUrlService = new AmazonService\Product\RootRelativeUrl(
            $this->modifiedTitleServiceMock,
            $this->urlFriendlyServiceMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\Product\RootRelativeUrl::class,
            $this->rootRelativeUrlService
        );
    }

    public function testGetModifiedTitle()
    {
        $productEntity            = new AmazonEntity\Product();
        $productEntity->productId = 12345;
        $productEntity->setTitle('My Amazing Product\'s Title (Is Great)');

        $this->urlFriendlyServiceMock->method('getUrlFriendly')->willReturn('My-Product-Title');

        $this->assertSame(
            '/products/12345/My-Product-Title',
            $this->rootRelativeUrlService->getRootRelativeUrl($productEntity)
        );
    }
}
