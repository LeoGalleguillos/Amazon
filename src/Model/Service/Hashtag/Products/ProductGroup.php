<?php
namespace LeoGalleguillos\Amazon\Model\Service\Hashtag\Products;

use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Hashtag\Model\Entity as HashtagEntity;

class ProductGroup
{
    public function __construct(
        AmazonFactory\Product $productFactory
    ) {
        $this->productFactory = $productFactory;
    }

    public function getProductEntities(
        AmazonFactory\Product $productFactory,
        HashtagEntity\Hashtag $hashtagEntity
    ) : array {
        return [];
    }
}
