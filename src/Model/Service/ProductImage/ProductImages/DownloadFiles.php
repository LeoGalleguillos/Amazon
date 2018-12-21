<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductImage\ProductImages;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use TypeError;

class DownloadFiles
{
    public function __construct(
        AmazonService\ProductImage\DownloadFile $downloadFileService
    ) {
        $this->downloadFileService = $downloadFileService;
    }

    public function downloadFiles(AmazonEntity\Product $productEntity)
    {
        $asin = $productEntity->getAsin();
        if (preg_match('/\W/', $asin)) {
            throw new Exception('ASIN contains invalid characters (this should never happen)');
        }

        if (!file_exists("/home/amazon/products/images/$asin")) {
            mkdir("/home/amazon/products/images/$asin");
        }

        try {
            $primaryImage = $productEntity->getPrimaryImage();
            $this->downloadFileService->downloadFile(
                $productEntity,
                $primaryImage
            );
        } catch (TypeError $typeError) {
            // Do nothing.
        }

        try {
            $variantImages = $productEntity->getVariantImages();
            foreach ($variantImages as $variantImage) {
                $this->downloadFileService->downloadFile(
                    $productEntity,
                    $variantImage
                );
            }
        } catch (TypeError $typeError) {
            // Do nothing.
        }
    }
}
