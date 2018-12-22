<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;
use TypeError;

class HasImage
{
    public function doesProductHaveImage(
        AmazonEntity\Product $productEntity
    ): bool {
        try {
            $productEntity->getPrimaryImage();
            return true;
        } catch (TypeError $typeError) {
            // Do nothing.
        }

        try {
            return !empty($productEntity->getVariantImages());
        } catch (TypeError $typeError) {
            // Do nothing.
        }

        return false;
    }
}
