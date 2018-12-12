<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductHiResImage;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class DownloadHiResImages
{
    public function downloadHiResImages(AmazonEntity\Product $productEntity)
    {
        $hiResImages = $productEntity->getHiResImages();

        $asin = $productEntity->getAsin();
        if (preg_match('/\W/', $asin)) {
            throw new Exception('ASIN contains invalid characters');
        }

        if (!file_exists('/home/amazon/products/hi-res-images/')) {
            mkdir('/home/amazon/products/hi-res-images/' . $asin);
        }

        foreach ($hiResImages as $hiResImage) {
            $fileName = basename($hiResImage->getUrl());
            if (!preg_match('/^[\w\.\_\%\-]+$/', $fileName)) {
                throw new Exception('Invalid file name (this should never happen)');
            }
            $destination = "/home/amazon/products/hi-res-images/$asin/$fileName";

            if (file_exists($destination)) {
                continue;
            }

            copy(
                $hiResImage->getUrl(),
                $destination
            );
        }
    }
}
