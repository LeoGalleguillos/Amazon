<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class Command
{
    public function getCommand(AmazonEntity\Product $productEntity): string
    {
		$code = [];
		$code[] = 'melt -verbose \\';
		$code[] = '-profile atsc_720p_25 \\';

		foreach ($productEntity->getHiResImages() as $hiResImage) {
			$fileName = basename($hiResImage);
            if (!preg_match('/^[\w\.]$/', $fileName)) {
                throw new Exception('Invalid file name (this should never happen)');
            }

            $asin = $productEntity->getAsin();
            if (!preg_match('/^\w+$/', $asin)) {
                throw new Exception('Invalid ASIN (this should never happen)');
            }

            $rru = "home/amazon/products/$asin/$fileName";

            $code[] = "$rru out=250 -mix 25 -mixer luma \\";
		}

        $audioLength    = count($productEntity->getHiResImages()) * 229;
        $startFadingOut = $audioLength - 100;

        $code[] = "-track /home/amazon/products/videos/ukelele.mp3 out=$audioLength \\";
        $code[] = "-attach-track volume:0db end=-70db in=$startFadingOut out=$audioLength \\";
        $code[] = "-transition mix \\";
        $code[] = "-consumer avformat:/home/amazon/products/videos/$asin.mp4 acodec=libmp3lame vcodec=libx264";

        return '';
    }
}
