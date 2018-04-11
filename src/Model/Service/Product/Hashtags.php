<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Hashtags
{
    public function __construct(
        AmazonService\Product\Hashtags\Insert $insertHashtagsService,
        AmazonService\Product\Hashtags\ProductEntity $productEntityHashtagsService,
        AmazonTable\Product\HashtagsRetrieved $hashtagsRetrievedTable,
        AmazonTable\ProductHashtag $productHashtagTable
    ) {
        $this->insertHashtagsService        = $insertHashtagsService;
        $this->productEntityHashtagsService = $productEntityHashtagsService;
        $this->hashtagsRetrievedTable       = $hashtagsRetrievedTable;
        $this->productHashtagTable          = $productHashtagTable;
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
            $this->insertHashtagsService->insert(
                $productEntity,
                $hashtags
            );
        }

        return $this->productHashtagTable->selectHashtagWhereProductId(
            $productEntity->getProductId()
        );
    }
}
