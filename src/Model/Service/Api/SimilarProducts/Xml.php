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
        $endpoint = "webservices.amazon.com";

        $uri = "/onca/xml";

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

        // Sort the parameters by key
        ksort($params);

        $pairs = [];

        foreach ($params as $key => $value) {
            array_push($pairs, rawurlencode($key) . '=' . rawurlencode($value));
        }

        // Generate the canonical query
        $canonical_query_string = join('&', $pairs);

        // Generate the string to be signed
        $string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;

        // Generate the signature required by the Product Advertising API
        $signature = base64_encode(hash_hmac('sha256', $string_to_sign, $this->secretAccessKey, true));

        // Generate the signed URL
        $request_url = 'https://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);

        $xmlString = file_get_contents($request_url);
        $xml = simplexml_load_string($xmlString);
        return $xml;
    }
}
