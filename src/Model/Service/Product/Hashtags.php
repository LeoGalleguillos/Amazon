<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Hashtags
{
    public function __construct(
        AmazonService\Product\Hashtags\ProductEntity $productEntityHashtagsService,
        AmazonTable\Product\HashtagsRetrieved $hashtagsRetrievedTable
    ) {
        $this->productEntityHashtagsService = $productEntityHashtagsService;
        $this->hashtagsRetrievedTable       = $hashtagsRetrievedTable;
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
            $hashtags = $this->productEntityHashtagsService->getHashtags(
                $productEntity
            );
            // Insert hashtags into mysql.
        }

        // Get hashtags from mysql and return them.

        return $hashtags;
    }
}
