<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\GetItems;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class Json
{
    public function __construct(
        string $partnerTag,
        string $accessKey,
        string $secretKey
    ) {
        $this->partnerTag = $partnerTag;
        $this->accessKey  = $accessKey;
        $this->secretKey  = $secretKey;
    }

    public function getJson(
        array $itemIds,
        array $resources
    ): string {
        if ((count($itemIds) < 1)
            || (count($itemIds) > 10)
        ) {
            throw new Exception('Invalid number of item IDs.');
        }

        if (empty($resources)) {
            throw new Exception('Invalid resources.');
        }

        $serviceName="ProductAdvertisingAPI";
        $region="us-east-1";
        $payloadArray = [
            'ItemIds' => $itemIds,
            'Resources' => $resources,
            'PartnerTag' => $this->partnerTag,
            'PartnerType' => 'Associates',
            'Marketplace' => 'www.amazon.com',
        ];
        $payloadString = json_encode($payloadArray);
        $host="webservices.amazon.com";
        $uriPath="/paapi5/getitems";
        $awsv4 = new AmazonEntity\Api\AwsV4(
            $this->accessKey,
            $this->secretKey
        );
        $awsv4->setRegionName($region);
        $awsv4->setServiceName($serviceName);
        $awsv4->setPath ($uriPath);
        $awsv4->setPayload ($payloadString);
        $awsv4->setRequestMethod ("POST");
        $awsv4->addHeader ('content-encoding', 'amz-1.0');
        $awsv4->addHeader ('content-type', 'application/json; charset=utf-8');
        $awsv4->addHeader ('host', $host);
        $awsv4->addHeader ('x-amz-target', 'com.amazon.paapi5.v1.ProductAdvertisingAPIv1.GetItems');
        $headers = $awsv4->getHeaders ();
        $headerString = "";
        foreach ( $headers as $key => $value ) {
            $headerString .= $key . ': ' . $value . "\r\n";
        }
        $params = array (
            'http' => array (
                'header' => $headerString,
                'method' => 'POST',
                'content' => $payloadString
            )
        );
        $stream = stream_context_create ( $params );

        $fp = fopen ( 'https://'.$host.$uriPath, 'rb', false, $stream );

        if (! $fp) {
            throw new Exception ( "Exception Occured" );
        }
        $response = @stream_get_contents ( $fp );
        if ($response === false) {
            throw new Exception ( "Exception Occured" );
        }
        return $response;
    }
}
