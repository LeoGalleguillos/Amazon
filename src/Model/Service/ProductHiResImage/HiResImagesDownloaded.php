<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductHiResImage;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use TypeError;

class HiResImagesDownloaded
{
    public function wereHiResImagesDownloaded(AmazonEntity\Product $productEntity): bool
    {
        $asin = $productEntity->getAsin();
        if (preg_match('/\W/', $asin)) {
            throw new Exception('ASIN contains invalid characters');
        }

        try {
            $hiResImages = $productEntity->getHiResImages();
        } catch (TypeError $typeError) {
            return false;
        }

        foreach ($hiResImages as $hiResImage) {
            $fileName = basename($hiResImage->getUrl());
            if (!preg_match('/^[\w\.\_\%\-]+$/', $fileName)) {
                throw new Exception('Invalid file name (this should never happen)');
            }
            $destination = "/home/amazon/products/hi-res-images/$asin/$fileName";

            if (file_exists($destination)) {
                return true;
            }
        }

        return false;
    }
}
