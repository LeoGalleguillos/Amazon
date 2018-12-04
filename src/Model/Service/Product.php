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
        AmazonService\Product\Download $productDownloadService,
        AmazonTable\Product $productTable
    ) {
        $this->productFactory         = $productFactory;
        $this->apiService             = $apiService;
        $this->apiProductXmlService   = $apiProductXmlService;
        $this->productDownloadService = $productDownloadService;
        $this->productTable           = $productTable;
    }

    /**
     * Get product.
     */
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
        $amazonProductEntity = $this->productFactory->buildFromXml($itemXml);
        $this->productDownloadService->downloadProduct($amazonProductEntity);

        return $amazonProductEntity;
    }
}
