<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo\Thumbnail;

use Imagick;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use TypeError;

class Generate
{
    public function generate(AmazonEntity\ProductVideo $productVideoEntity): bool
    {
        $productEntity = $productVideoEntity->getProduct();

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

        $fileName      = urldecode(basename($imageEntities[0]->getUrl()));
        $asin          = $productEntity->getAsin();
        $source        = "/home/amazon/products/images/$asin/$fileName";
        $destination   = "/home/amazon/products/videos/thumbnails/$asin.jpg";

        if (!file_exists($source)
            || file_exists($destination)
        ) {
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
