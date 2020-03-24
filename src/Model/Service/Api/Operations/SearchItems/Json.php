<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Operations\SearchItems;

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
        string $keywords,
        array $resources
    ): string {
        if (empty($resources)) {
            throw new Exception('Invalid resources.');
        }

        $serviceName="ProductAdvertisingAPI";
        $region="us-east-1";
        $payloadArray = [
            'Keywords' => $keywords,
            'Resources' => $resources,
            'PartnerTag' => $this->partnerTag,
            'PartnerType' => 'Associates',
            'Marketplace' => 'www.amazon.com',
        ];
        $payloadString = json_encode($payloadArray);
        $host="webservices.amazon.com";
        $uriPath="/paapi5/searchitems";
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
        $awsv4->addHeader ('x-amz-target', 'com.amazon.paapi5.v1.ProductAdvertisingAPIv1.SearchItems');
        $headers = $awsv4->getHeaders ();
        $headersArray = [];
        foreach ($headers as $key => $value ) {
            $headersArray[] = $key . ': ' . $value;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,'https://'.$host.$uriPath);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$payloadString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headersArray);
        $jsonString = curl_exec($ch);
        curl_close($ch);

        return $jsonString;

    }
}
