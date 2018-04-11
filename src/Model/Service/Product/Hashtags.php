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
    ) : array {
        try {
            $hashtagsRetrieved = $this->hashtagsRetrievedTable->selectWhereProductId(
                $productEntity->getProductId()
            );
        } catch (Exception $exception) {
            $this->hashtagsRetrievedTable->updateWhereProductId(
                $productEntity->getProductId()
            );
            // Insert hashtags into mysql.
        }

        // Get hashtags from mysql and return them.

        return $hashtags;
    }
}
