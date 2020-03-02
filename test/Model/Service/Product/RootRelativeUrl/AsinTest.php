<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\RootRelativeUrl;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\String\Model\Service as StringService;
use PHPUnit\Framework\TestCase;

class AsinTest extends TestCase
{
    protected function setUp()
    {
        $this->urlFriendlyServiceMock = $this->createMock(
            StringService\UrlFriendly::class
        );
        $this->asinService = new AmazonService\Product\RootRelativeUrl\Asin(
            $this->urlFriendlyServiceMock
        );
    }

    public function testGetRootRelativeUrl()
    {
        $productEntity = new AmazonEntity\Product();
        $productEntity->setAsin('ASIN005');
        $productEntity->setTitle('My Product Title');

        $this->urlFriendlyServiceMock
            ->method('getUrlFriendly')
            ->willReturn('my-product-title');

        $this->assertSame(
            '/watch/ASIN005/my-product-title',
            $this->asinService->getRootRelativeUrl($productEntity)
        );
    }
}
