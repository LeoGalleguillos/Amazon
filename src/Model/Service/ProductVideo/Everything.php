<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;

/**
 * Everything
 *
 * Everything required to generated a product video from hi-res photos
 */
class Everything
{
    public function __construct(
        AmazonFactory\Product $productFactory,
        AmazonService\ProductHiResImage\DownloadUrls $downloadUrlsService,
        AmazonService\ProductHiResImage\DownloadHiResImages $downloadHiResImagesService,
        AmazonService\ProductVideo\Generate $generateService
    ) {
        $this->productFactory             = $productFactory;
        $this->downloadUrlsService        = $downloadUrlsService;
        $this->downloadHiResImagesService = $downloadHiResImagesService;
        $this->generateService            = $generateService;
    }

    public function doEverything(AmazonEntity\Product $productEntity): bool
    {
        $this->downloadUrlsService->downloadUrls($productEntity);

        $productEntity = $this->productFactory->buildFromAsin(
            $productEntity->getAsin()
        );

        $this->downloadHiResImagesService->downloadHiResImages($productEntity);

        $productEntity = $this->productFactory->buildFromAsin(
            $productEntity->getAsin()
        );

        // Update video_generated timestamp in product table

        $this->generateService->generate($productEntity);

        // Insert into product_video table

        return true;
    }
}
