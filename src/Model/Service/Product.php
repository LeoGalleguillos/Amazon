<?php
namespace LeoGalleguillos\Amazon\Model\Service;

use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Product
{
    public function __construct(
        AmazonFactory\Product $productFactory,
        AmazonService\Api $apiService,
        AmazonService\Api\Product\Xml $apiProductXmlService,
        AmazonService\Api\Product\Xml\DownloadToMySql $downloadToMySqlService,
        AmazonTable\Product $productTable
    ) {
        $this->productFactory         = $productFactory;
        $this->apiService             = $apiService;
        $this->apiProductXmlService   = $apiProductXmlService;
        $this->downloadToMySqlService = $downloadToMySqlService;
        $this->productTable           = $productTable;
    }

    public function getProduct(string $asin)
    {
        if ($this->productTable->isProductInTable($asin)) {
            return $this->productFactory->buildFromAsin($asin);
        }

        if (!AmazonService\Api::GET_NEW_PRODUCTS) {
            return false;
        }

        if ($this->apiService->wasAmazonApiCalledRecently()) {
            return false;
        }

        $xml = $this->apiProductXmlService->getXml($asin);
        if (!isset($xml->{'Items'}->{'Item'})) {
            return false;
        }
        $itemXml = $xml->{'Items'}->{'Item'};

        $this->downloadToMySqlService->downloadToMySql($itemXml);

        return $this->productFactory->buildFromAsin($asin);
    }
}
