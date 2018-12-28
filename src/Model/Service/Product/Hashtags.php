<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class Hashtags
{
    public function __construct(
        AmazonService\Product\Hashtags\ProductEntity $productEntityHashtagsService
    ) {
        $this->productEntityHashtagsService = $productEntityHashtagsService;
    }

    public function getHashtags(
        AmazonEntity\Product $productEntity
    ): array {
        return $this->productEntityHashtagsService->getHashtags(
            $productEntity
        );
    }
}
