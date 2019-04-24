<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductImage;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;
use TypeError;

class ProductImages
{
    /**
     * @return ImageEntity\Image[]
     */
    public function getProductImages(
        AmazonEntity\Product $productEntity
    ): array {
        $imageEntities = [];

        try {
            $imageEntities[] = $productEntity->getPrimaryImage();
        } catch (TypeError $typeError) {
            // Do nothing.
        }

        try {
            $imageEntities = array_merge(
                $imageEntities,
                $productEntity->getVariantImages()
            );
        } catch (TypeError $typeError) {
            // Do nothing.
        }

        return $imageEntities;
    }
}
