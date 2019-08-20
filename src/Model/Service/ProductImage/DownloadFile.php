<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductImage;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;
use TypeError;

class DownloadFile
{
    public function downloadFile(
        AmazonEntity\Product $productEntity,
        ImageEntity\Image $imageEntity
    ): bool {
        $asin = $productEntity->getAsin();
        if (preg_match('/\W/', $asin)) {
            throw new Exception('ASIN contains invalid characters (this should never happen)');
        }

        if (!file_exists("/home/amazon/products/images/$asin")) {
            mkdir("/home/amazon/products/images/$asin");
        }

        $fileName = urldecode(basename($imageEntity->getUrl()));
        if (!preg_match('/^[\w\.\_\+\-]+$/', $fileName)) {
            throw new Exception('Invalid file name (this should never happen): ' . $fileName);
        }

        $destination = "/home/amazon/products/images/$asin/$fileName";

        if (file_exists($destination)) {
            return true;
        } else {
            return copy($imageEntity->getUrl(), $destination);
        }
    }
}
