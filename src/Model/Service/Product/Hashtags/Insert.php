<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\Hashtags;

use TypeError;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Hashtag\Model\Service as HashtagService;

class Insert
{
    public function __construct(
        AmazonTable\ProductHashtag $productHashtagTable,
        HashtagService\Hashtag $hashtagService
    ) {
        $this->productHashtagTable = $productHashtagTable;
        $this->hashtagService      = $hashtagService;
    }

    public function insert(
        AmazonEntity\Product $productEntity,
        array $hashtags
    ) {
        foreach ($hashtags as $hashtag) {
            $hashtagId = $this->hashtagService->tryToGetHashtagIdOrInsertAndGetHashtagId(
                $hashtag
            );
            try {
                $productGroupId = $productEntity->getProductGroupEntity()
                                                ->getProductGroupId();
            } catch (TypeError $error) {
                $productGroupId = null;
            }
            try {
                $bindingId = $productEntity->getBindingEntity()
                                           ->getBindingId();
            } catch (TypeError $error) {
                $bindingId = null;
            }
            try {
                $brandId = $productEntity->getBrandEntity()
                                         ->getBrandId();
            } catch (TypeError $error) {
                $brandId = null;
            }
            $this->productHashtagTable->insertIgnore(
                $productEntity->getProductId(),
                $hashtagId,
                $productGroupId,
                $bindingId,
                $brandId
            );
        }
    }
}
