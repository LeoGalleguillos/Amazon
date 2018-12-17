<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Video\Model\Service as VideoService;
use TypeError;

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
        AmazonService\ProductVideo\Generate $generateProductVideoService,
        AmazonService\ProductVideo\Thumbnail\Generate $generateThumbnail,
        AmazonTable\Product\HiResImagesRetrieved $hiResImagesRetrievedTable,
        AmazonTable\Product\VideoGenerated $videoGeneratedTable,
        AmazonTable\ProductVideo $productVideoTable,
        VideoService\DurationMilliseconds $durationMillisecondsService
    ) {
        $this->productFactory              = $productFactory;
        $this->downloadUrlsService         = $downloadUrlsService;
        $this->downloadHiResImagesService  = $downloadHiResImagesService;
        $this->generateProductVideoService = $generateProductVideoService;
        $this->generateThumbnail           = $generateThumbnail;
        $this->hiResImagesRetrievedTable   = $hiResImagesRetrievedTable;
        $this->videoGeneratedTable         = $videoGeneratedTable;
        $this->productVideoTable           = $productVideoTable;
        $this->durationMillisecondsService = $durationMillisecondsService;
    }

    public function doEverything(AmazonEntity\Product $productEntity): bool
    {
        try {
            $videoGenerated = $productEntity->getVideoGenerated();
            return false;
        } catch (TypeError $typeError) {
            // Do nothing.
        }

        $this->downloadUrlsService->downloadUrls($productEntity);
        $this->hiResImagesRetrievedTable->updateSetToUtcTimestampWhereProductId(
            $productEntity->getProductId()
        );

        $productEntity = $this->productFactory->buildFromAsin(
            $productEntity->getAsin()
        );

        $this->downloadHiResImagesService->downloadHiResImages($productEntity);

        $productEntity = $this->productFactory->buildFromAsin(
            $productEntity->getAsin()
        );

        $this->videoGeneratedTable->updateSetToUtcTimestampWhereProductId(
            $productEntity->getProductId()
        );

        if (empty($productEntity->getHiResImages())) {
            return false;
        }

        $this->generateProductVideoService->generate($productEntity);

        $asin = $productEntity->getAsin();
        $rru  = "/home/amazon/products/videos/$asin.mp4";

        $this->productVideoTable->insert(
            $productEntity->getProductId(),
            $productEntity->getTitle(),
            $this->durationMillisecondsService->getDurationMilliseconds($rru)
        );

        $productVideoEntity = new AmazonEntity\ProductVideo();
        $productVideoEntity->setProduct($productEntity);
        $this->generateThumbnailService->generate($productVideoEntity);

        return true;
    }
}
