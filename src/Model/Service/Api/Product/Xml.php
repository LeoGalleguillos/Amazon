<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Product;

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

    /**
     * Get XML
     *
     * @param string $asin
     * @return SimpleXMLElement
     */
    public function getXml(string $asin) : SimpleXMLElement
    {
        $params = [
            'Service'        => 'AWSECommerceService',
            'Operation'      => 'ItemLookup',
            'AWSAccessKeyId' => $this->accessKeyId,
            'AssociateTag'   => $this->associateTag,
            'ItemId'         => $asin,
            'IdType'         => 'ASIN',
            'ResponseGroup'  => 'Large',
            'Timestamp'      => gmdate('Y-m-d\TH:i:s\Z'),
        ];

        // Sort the parameters by key
        ksort($params);

        $pairs = array();

        foreach ($params as $key => $value) {
            array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
        }

        // Generate the canonical query
        $canonical_query_string = join("&", $pairs);

        // Generate the string to be signed
        $string_to_sign = "GET\n".'webservices.amazon.com'."\n".'/onca/xml'."\n".$canonical_query_string;

        // Generate the signature required by the Product Advertising API
        $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $this->secretAccessKey, true));

        // Generate the signed URL
        $request_url = 'https://webservices.amazon.com/onca/xml?'.$canonical_query_string.'&Signature='.rawurlencode($signature);

        $xmlString = file_get_contents($request_url);
        $xml = simplexml_load_string($xmlString);
        return $xml;
    }
}
