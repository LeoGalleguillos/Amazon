<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Hashtags
{
    public function __construct(
        AmazonTable\Product\HashtagsRetrieved $hashtagsRetrievedTable
    ) {
        $this->hashtagsRetrievedTable = $hashtagsRetrievedTable;
    }

    public function getHashtags(
        AmazonEntity\Product $productEntity
    ) {

    }
}
