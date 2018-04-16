<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;
use TypeError;

class FirstImageEntity
{
    public function getFirstImage(
        AmazonEntity\Product $productEntity
    ) : ImageEntity\Image {
        try {
            return $productEntity->getPrimaryImage();
        } catch (TypeError $typeError) {
            // Do nothing.
        }

        if (!empty($variantImages = $productEntity->getVariantImages())) {
            return $variantImages[0];
        }

        throw new Exception('Unable to get first image.');
    }
}
