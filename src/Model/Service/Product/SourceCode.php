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
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0',
        ];

        curl_setopt_array($ch, $curlOptions);

        return curl_exec($ch);
    }
}
