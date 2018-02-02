<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class SimilarProducts
{
    public function __construct(
        AmazonFactory\Product $amazonProductFactory,
        AmazonService\Api $amazonApiService,
        AmazonService\Api\SimilarProducts\Xml $apiSimilarProductsXmlService,
        AmazonService\Product $amazonProductService,
        AmazonService\Product\Download $amazonProductDownloadService,
        AmazonTable\Product\Similar $amazonProductSimilarTable,
        AmazonTable\Product\SimilarRetrieved $amazonProductSimilarRetrievedTable
    ) {
        $this->amazonProductFactory               = $amazonProductFactory;
        $this->amazonApiService                   = $amazonApiService;
        $this->apiSimilarProductsXmlService       = $apiSimilarProductsXmlService;
        $this->amazonProductService               = $amazonProductService;
        $this->amazonProductDownloadService       = $amazonProductDownloadService;
        $this->amazonProductSimilarTable          = $amazonProductSimilarTable;
        $this->amazonProductSimilarRetrievedTable = $amazonProductSimilarRetrievedTable;
    }

    public function getSimilarProducts($asin)
    {
        $products = [];

        $asins = $this->amazonProductSimilarTable->getSimilarAsins($asin);
        if (!empty($asins)) {
            foreach ($asins as $asin) {
                $products[] = $this->amazonProductFactory->createFromMySql($asin);
            }
            return $products;
        }

        if (!AmazonService\Api::GET_NEW_PRODUCTS
            || $this->amazonApiService->wasAmazonApiCalledRecently()
            || $this->amazonProductService->wereSimilarProductsRetrievedRecently($asin)
        ) {
            return [];
        }

        $xml = $this->apiSimilarProductsXmlService->getXml($asin);

        $this->amazonApiService->insertOnDuplicateKeyUpdate(
            'last_call_microtime',
            microtime(true)
        );
        $this->amazonProductSimilarRetrievedTable->updateToNowWhereAsin($asin);

        if (!empty($xml->{'Items'}->{'Item'})) {
            foreach ($xml->{'Items'}->{'Item'} as $itemXml) {
                $product = $this->amazonProductFactory->createFromXml($itemXml);

                if ($this->amazonProductService->isAmazonProductBanned($product->asin)) {
                    continue;
                }

                if (!$this->isProductInTable($product->asin)) {
                    $this->amazonProductDownloadService->downloadProduct($product);
                }

                $this->amazonProductSimilarTable->insertIfNotExists($asin, $product->asin);
                $products[] = $product;
            }
        }

        return $products;
    }
}
