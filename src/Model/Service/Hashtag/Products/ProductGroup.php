<?php
namespace LeoGalleguillos\Amazon\Model\Service\Hashtag\Products;

use Generator;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Hashtag\Model\Entity as HashtagEntity;

class ProductGroup
{
    public function __construct(
        AmazonFactory\Product $productFactory,
        AmazonTable\ProductHashtag $productHashtagTable
    ) {
        $this->productFactory      = $productFactory;
        $this->productHashtagTable = $productHashtagTable;
    }

    /**
     * Get product entities.
     *
     * @param HashtagEntity\Hashtag $hashtagEntity,
     * @param AmazonEntity\ProductGroup $productGroupEntity
     * @return Generator
     * @yield AmazonEntity\Product
     */
    public function getProductEntities(
        HashtagEntity\Hashtag $hashtagEntity,
        AmazonEntity\ProductGroup $productGroupEntity
    ) : Generator {
        $productIds = $this->productHashtagTable
                           ->selectProductIdWhereHashtagIdProductGroupId(
            $hashtagEntity->getHashtagId(),
            $productGroupEntity->getProductGroupId()
        );

        foreach ($productIds as $productId) {
            yield $this->productFactory->buildFromProductId($productId);
        }
    }
}
