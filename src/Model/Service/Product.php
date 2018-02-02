<?php
namespace LeoGalleguillos\Amazon\Model\Service;

use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Product
{
    public function __construct(
        AmazonFactory\Product $amazonProductFactory,
        AmazonService\Api $amazonApiService,
        AmazonService\Api\Product\Xml $apiProductXmlService,
        AmazonService\Product\Download $amazonProductDownloadService,
        AmazonTable\Product $amazonProductTable
    ) {
        $this->amazonProductFactory         = $amazonProductFactory;
        $this->amazonApiService             = $amazonApiService;
        $this->apiProductXmlService         = $apiProductXmlService;
        $this->amazonProductDownloadService = $amazonProductDownloadService;
        $this->amazonProductTable           = $amazonProductTable;
    }

    /**
     * Get product.
     */
    public function getProduct(string $asin)
    {
        if ($this->isProductBanned($asin)) {
            return false;
        }

        if ($this->isProductInTable($asin)) {
            return $this->amazonProductFactory->createFromMySql($asin);
        }

        if (!AmazonService\Api::GET_NEW_PRODUCTS) {
            return false;
        }

        if ($this->amazonApiService->wasAmazonApiCalledRecently()) {
            return false;
        }

        $xml = $this->getProductXml($asin);
        if (!isset($xml->{'Items'}->{'Item'})) {
            return false;
        }
        $itemXml = $xml->{'Items'}->{'Item'};
        $amazonProductEntity = $this->amazonProductFactory->createFromXml($itemXml);
        $this->amazonProductDownloadService->downloadProduct($amazonProductEntity);

        return $amazonProductEntity;
    }

    /**
     * @TODO
     */
    public function isProductBanned($asin)
    {
        return false;
    }

    public function isProductInTable($asin)
    {
        return $this->amazonProductTable->isProductInTable($asin);
    }
}
