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

    public function downloadFiles(AmazonEntity\Product $productEntity): bool
    {
        $allFilesDownloadedSuccessfully = true;

        $asin = $productEntity->getAsin();
        if (preg_match('/\W/', $asin)) {
            throw new Exception('ASIN contains invalid characters (this should never happen)');
        }

        if (!file_exists("/home/amazon/products/images/$asin")) {
            mkdir("/home/amazon/products/images/$asin");
        }

        try {
            $primaryImage = $productEntity->getPrimaryImage();
            $fileDownloadedSuccessfully = $this->downloadFileService->downloadFile(
                $productEntity,
                $primaryImage
            );
            if (!$fileDownloadedSuccessfully) {
                $allFilesDownloadedSuccessfully = false;
            }
        } catch (TypeError $typeError) {
            // Do nothing.
        }

        try {
            $variantImages = $productEntity->getVariantImages();
            foreach ($variantImages as $variantImage) {
                $fileDownloadedSuccessfully = $this->downloadFileService->downloadFile(
                    $productEntity,
                    $variantImage
                );
                if (!$fileDownloadedSuccessfully) {
                    $allFilesDownloadedSuccessfully = false;
                }
            }
        } catch (TypeError $typeError) {
            // Do nothing.
        }

        return $allFilesDownloadedSuccessfully;
    }
}
