<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class SourceCode
{
    public function getSourceCode(AmazonEntity\Product $productEntity): string
    {
        $url = 'https://www.amazon.com/dp/' . $productEntity->getAsin();

        $ch = curl_init($url);
        $curlOptions = [
            CURLOPT_ENCODING       => 'gzip',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36',
        ];

        curl_setopt_array($ch, $curlOptions);

        return curl_exec($ch);
    }
}
