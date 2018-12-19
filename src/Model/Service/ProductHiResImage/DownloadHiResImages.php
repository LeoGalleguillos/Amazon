<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductHiResImage;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class DownloadHiResImages
{
    public function downloadHiResImages(AmazonEntity\Product $productEntity)
    {
        $hiResImages = $productEntity->getHiResImages();

        if (empty($hiResImages)) {
            return;
        }

        $asin = $productEntity->getAsin();
        if (preg_match('/\W/', $asin)) {
            throw new Exception('ASIN contains invalid characters');
        }

        if (!file_exists("/home/amazon/products/hi-res-images/$asin")) {
            mkdir("/home/amazon/products/hi-res-images/$asin");
        }

        foreach ($hiResImages as $hiResImage) {
            $fileName = urldecode(basename($hiResImage->getUrl()));
            if (!preg_match('/^[\w\.\_\+\-]+$/', $fileName)) {
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
