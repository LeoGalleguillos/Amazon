<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class TweetTest extends TestCase
{
    protected function setUp()
    {
        $this->hashtagsServiceMock = $this->createMock(
            AmazonService\Product\Hashtags::class
        );
        $this->urlServiceMock = $this->createMock(
            AmazonService\Product\Url::class
        );
        $this->tweetService = new AmazonService\Product\Tweet(
            $this->hashtagsServiceMock,
            $this->urlServiceMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\Product\Tweet::class,
            $this->tweetService
        );
    }
}
