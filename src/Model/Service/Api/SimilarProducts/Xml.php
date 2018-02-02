<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\SimilarProducts;

use SimpleXMLElement;

class Xml
{
    public function __construct(
        string $accessKeyId,
        string $associateTag,
        string $secretAccessKey
    ) {
        $this->accessKeyId     = $accessKeyId;
        $this->associateTag    = $associateTag;
        $this->secretAccessKey = $secretAccessKey;
    }

    public function getXml($asin)
    {
        $params = [
            'Service'        => 'AWSECommerceService',
            'Operation'      => 'SimilarityLookup',
            'AWSAccessKeyId' => $this->accessKeyId,
            'AssociateTag'   => $this->associateTag,
            'ItemId'         => $asin,
            'MerchantId'     => 'Amazon',
            'ResponseGroup'  => 'Large',
            'Timestamp'      => gmdate('Y-m-d\TH:i:s\Z'),
        ];
        ksort($params);

        $pairs = [];
        foreach ($params as $key => $value) {
            array_push(
                $pairs,
                urlencode($key) . '=' . urlencode($value)
            );
        }

        $queryString = join('&', $pairs);

        $stringToSign = "GET\n"
                      . "webservices.amazon.com\n"
                      . "/onca/xml\n"
                      . $queryString;

        $signature = base64_encode(hash_hmac(
            'sha256',
            $stringToSign,
            $this->secretAccessKey,
            true
        ));

        $signedUrl = 'https://webservices.amazon.com/onca/xml?'
                   . $queryString
                   . '&Signature=' . urlencode($signature);

        $xmlString = file_get_contents($signedUrl);
        return simplexml_load_string($xmlString);
    }
}
