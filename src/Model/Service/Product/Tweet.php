<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Tweet
{
    const TWEET_MAX_LENGTH = 280;

    /**
     * Construct.
     */
    public function __construct(
        AmazonService\Product\Hashtags $hashtagsService,
        AmazonService\Product\Url $urlService
    ) {
        $this->hashtagsService = $hashtagsService;
        $this->urlService      = $urlService;
    }

    /**
     * Get Tweet.
     *
     * @param AmazonEntity\Product $productEntity
     * @return string
     */
    public function getTweet(AmazonEntity\Product $productEntity) : string
    {
        $tweet = $productEntity->getTitle();
        $tweet .= ' ';
        $tweet .= $this->urlService->getUrl($productEntity);

        $hashtags = $this->hashtagsService->getHashtags(
            $productEntity
        );

        foreach ($hashtags as $hashtag) {
            $append = " #$hashtag";
            if ((strlen($tweet) + strlen($append)) <= self::TWEET_MAX_LENGTH) {
                $tweet .= $append;
            }
        }

        return $tweet;
    }
}
