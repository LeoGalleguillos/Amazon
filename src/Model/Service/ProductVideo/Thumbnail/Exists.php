<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo\Thumbnail;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class Exists
{
    public function doesThumbnailExist(AmazonEntity\ProductVideo $productVideoEntity): bool
    {
        $asin = $productVideoEntity->getProduct()->getAsin();

        return file_exists(
            "/home/amazon/products/videos/thumbnails/$asin.jpg"
        );
    }
}
