<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductHiResImage;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class DownloadImages
{
    public function downloadImages(AmazonEntity\Product $productEntity)
    {
        $hiResImages = $productEntity->getHiResImages();

        $asin = $productEntity->getAsin();
        if (preg_match('/\W/', $asin)) {
            throw new Exception('ASIN contains invalid characters');
        }
        mkdir('/home/amazon/products/hi-res-images/' . $asin);

        foreach ($hiResImages as $hiResImage) {
            $fileName = basename($hiResImage->getUrl());
            if (!preg_match('/^[\w\.]+$/', $fileName)) {
                throw new Exception('File name contains invalid characters');
            }
            $destination = "/home/amazon/products/hi-res-images/$asin/$fileName";

            if (file_exists($destination)) {
                throw new Exception('File already exists');
            }

            copy(
                $hiResImage->getUrl(),
                $destination
            );
        }
    }
}
