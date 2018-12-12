<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class Generated
{
    public function wasGenerated(AmazonEntity\Product $productEntity): bool
    {
        $asin = $productEntity->getAsin();

        if (preg_match('/\W/', $asin)) {
            throw new Exception('Invalid ASIN (this should never happen)');
        }

        return file_exists(
            "/home/amazon/products/videos/$asin.mp4"
        );
    }
}
