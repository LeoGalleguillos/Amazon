<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product\Hashtags;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Hashtag\Model\Service as HashtagService;
use PHPUnit\Framework\TestCase;

class InsertTest extends TestCase
{
    protected function setUp()
    {
        $this->productHashtagTableMock = $this->createMock(
            AmazonTable\ProductHashtag::class
        );
        $this->hashtagServiceMock = $this->createMock(
            HashtagService\Hashtag::class
        );
        $this->insertService = new AmazonService\Product\Hashtags\Insert(
            $this->productHashtagTableMock,
            $this->hashtagServiceMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\Product\Hashtags\Insert::class,
            $this->insertService
        );
    }

    public function testInsert()
    {
        $productEntity = new AmazonEntity\Product();
        $productEntity->setProductId(123);
        $hashtags      = ['amazing', 'fantasitc', 'super'];

        $this->hashtagServiceMock
             ->method('tryToGetHashtagIdOrInsertAndGetHashtagId')
             ->willReturn(3);

        $this->assertNull(
            $this->insertService->insert(
                $productEntity,
                $hashtags
            )
        );
    }
}
