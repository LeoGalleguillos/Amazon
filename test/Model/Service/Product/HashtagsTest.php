<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class HashtagsTest extends TestCase
{
    protected function setUp()
    {
        $this->productEntityHashtagsServiceMock = $this->createMock(
            AmazonService\Product\Hashtags\ProductEntity::class
        );
        $this->hashtagsService = new AmazonService\Product\Hashtags(
            $this->productEntityHashtagsServiceMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\Product\Hashtags::class,
            $this->hashtagsService
        );
    }

    public function testGetHashtags()
    {
        $productEntity = new AmazonEntity\Product();
        $productEntity->setProductId(1);

        $this->assertSame(
            [],
            $this->hashtagsService->getHashtags($productEntity)
        );
    }
}
