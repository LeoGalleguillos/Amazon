<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;
use TypeError;

/**
 * @todo This service can probably be renamed to just FirstImage
 *       with method name ::getFirstImage()
 */
class FirstImageEntity
{
    /**
     * @throws Exception
     */
    public function getFirstImageEntity(
        AmazonEntity\Product $productEntity
    ): ImageEntity\Image {
        try {
            return $productEntity->getPrimaryImage();
        } catch (TypeError $typeError) {
            // Do nothing.
        }

        try {
            $variantImages = $productEntity->getVariantImages();
        } catch (TypeError $typeError) {
            // Do nothing.
        }

        if (empty($variantImages)) {
            throw new Exception('Unable to get first image.');
        }

        return $variantImages[0];
    }
}
