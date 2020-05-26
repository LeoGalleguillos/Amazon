<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product\Url;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class AsinTest extends TestCase
{
    protected function setUp(): void
    {
        $this->domainServiceMock = $this->createMock(
            AmazonService\Product\Domain::class
        );
        $this->asinRootRelativeUrlMock = $this->createMock(
            AmazonService\Product\RootRelativeUrl\Asin::class
        );
        $this->asinService = new AmazonService\Product\Url\Asin(
            $this->domainServiceMock,
            $this->asinRootRelativeUrlMock
        );
    }

    public function testGetUrl()
    {
        $this->domainServiceMock
            ->method('getDomain')
            ->willReturn('www.example.com');
        $this->asinRootRelativeUrlMock
            ->method('getRootRelativeUrl')
            ->willReturn('/watch/ASIN009/example-slug');

        $productEntity = new AmazonEntity\Product();
        $productEntity->setAsin('ASIN009');

        $this->assertSame(
            'https://www.example.com/watch/ASIN009/example-slug',
            $this->asinService->getUrl($productEntity)
        );
    }
}
