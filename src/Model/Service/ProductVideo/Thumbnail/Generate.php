<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo\Thumbnail;

use Imagick;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class Generate
{
    public function generate(AmazonEntity\ProductVideo $productVideoEntity): bool
    {
        $productEntity = $productVideoEntity->getProduct();
        $hiResImageUrl = $productEntity->getHiResImages()[0]->getUrl();
        $fileName      = urldecode(basename($hiResImageUrl));
        $asin          = $productEntity->getAsin();
        $source        = "/home/amazon/products/hi-res-images/$asin/$fileName";
        $destination   = "/home/amazon/products/videos/thumbnails/$asin.jpg";

        if (file_exists($destination)) {
            return false;
        }

        $imagick = new \Imagick();
        $imagick->readImage($source);
        $imagick->scaleImage(1280, 720, true);
        $width = $imagick->getImageWidth();
        $height = $imagick->getImageHeight();

        $imagick->extentImage(
            1280,
            720,
            -(1280 - $width)/2,
            -(720 - $height)/2
        );
        $imagick->writeImage($destination);

        return true;
    }
}
