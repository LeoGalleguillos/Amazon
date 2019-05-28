<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Video\Model\Service as VideoService;

/**
 * Everything
 *
 * Do everything required to generate a product video.
 */
class Everything
{
    public function __construct(
        AmazonService\Product\HasImage $hasImageService,
        AmazonService\ProductImage\ProductImages\DownloadFiles $downloadFilesService,
        AmazonService\ProductVideo\Generate $generateProductVideoService,
        AmazonService\ProductVideo\Thumbnail\Generate $generateThumbnailService,
        AmazonTable\Product\VideoGenerated $videoGeneratedTable,
        AmazonTable\ProductFeature $productFeatureTable,
        AmazonTable\ProductVideo $productVideoTable,
        VideoService\DurationMilliseconds $durationMillisecondsService
    ) {
        $this->hasImageService             = $hasImageService;
        $this->downloadFilesService        = $downloadFilesService;
        $this->generateProductVideoService = $generateProductVideoService;
        $this->generateThumbnailService    = $generateThumbnailService;
        $this->videoGeneratedTable         = $videoGeneratedTable;
        $this->productFeatureTable         = $productFeatureTable;
        $this->productVideoTable           = $productVideoTable;
        $this->durationMillisecondsService = $durationMillisecondsService;
    }

    public function doEverything(AmazonEntity\Product $productEntity): bool
    {
        $this->videoGeneratedTable->updateSetToUtcTimestampWhereProductId(
            $productEntity->getProductId()
        );

        if (!$this->hasImageService->doesProductHaveImage($productEntity)) {
            return false;
        }

        $this->downloadFilesService->downloadFiles($productEntity);

        $this->generateProductVideoService->generate($productEntity);

        $asin = $productEntity->getAsin();

        if (!preg_match('/^\w+$/', $asin)) {
            throw new Exception('Invalid ASIN (this should never happen)');
        }

        $rru  = "/home/amazon/products/videos/$asin.mp4";

        $command = "/home/onlinefr/s3cmd-master/s3cmd put $rru s3://videosofproducts/products/videos/ --acl-public --recursive --verbose";
        exec($command);

        $productFeatureArrays = $this->productFeatureTable->selectWhereProductId(
            $productEntity->getProductId()
        );
        $features = [];
        foreach ($productFeatureArrays as $productFeatureArray) {
            $features .= $productFeatureArray['feature'];
        }
        $description = empty($features)
            ? null
            : implode("\n", $features);

        $this->productVideoTable->insertOnDuplicateKeyUpdate(
            $productEntity->getProductId(),
            $productEntity->getTitle(),
            $description,
            $this->durationMillisecondsService->getDurationMilliseconds($rru)
        );

        $productVideoEntity = new AmazonEntity\ProductVideo();
        $productVideoEntity->setProduct($productEntity);
        $this->generateThumbnailService->generate($productVideoEntity);

        $rru     = "/home/amazon/products/videos/thumbnails/$asin.jpg";
        $command = "/home/onlinefr/s3cmd-master/s3cmd put $rru s3://videosofproducts/products/videos/thumbnails/ --acl-public --recursive --verbose";
        exec($command);

        return true;
    }
}
