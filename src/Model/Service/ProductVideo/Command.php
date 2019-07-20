<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use TypeError;

class Command
{
    public function __construct(
        AmazonService\ProductVideo\RandomMp3Rru $randomMp3RruService
    ) {
        $this->randomMp3RruService = $randomMp3RruService;
    }

    public function getCommand(AmazonEntity\Product $productEntity): string
    {
        $code = [];
        $code[] = 'melt -verbose \\';
        $code[] = '-profile atsc_720p_25 \\';

        $asin = $productEntity->getAsin();
        if (!preg_match('/^\w+$/', $asin)) {
            throw new Exception('Invalid ASIN (this should never happen)');
        }

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

        $imageDuration = count($imageEntities) > 1
            ? 125
            : 250;

        foreach ($imageEntities as $imageEntity) {
            $fileName = urldecode(basename($imageEntity->getUrl()));
            if (!preg_match('/^[\w\.\_\+\-]+$/', $fileName)) {
                throw new Exception('Invalid file name (this should never happen)');
            }

            $rru = "/home/amazon/products/images/$asin/$fileName";

            $code[] = "$rru out=$imageDuration -mix 25 -mixer luma \\";
        }

        $audioLength = (count($imageEntities) > 1)
            ? count($imageEntities) * 100
            : 229;
        $startFadingOut = $audioLength - 50;

        $randomMp3Rru = $this->randomMp3RruService->getRandomMp3Rru();

        $code[] = "-track \"$randomMp3Rru\" out=$audioLength \\";
        $code[] = "-attach-track volume:0db end=-70db in=$startFadingOut out=$audioLength \\";
        $code[] = "-transition mix \\";

        $rru = "/home/amazon/products/videos/$asin.mp4";
        if (file_exists($rru)) {
            $tmpRru = "/home/amazon/tmp/$asin.mp4";

            $code[] = "-consumer avformat:$tmpRru acodec=aac vcodec=libx264 \\";
            $code[] = "&& mv $tmpRru $rru";
        } else {
            $code[] = "-consumer avformat:$rru acodec=aac vcodec=libx264";
        }

        return implode("\n", $code);
    }
}
