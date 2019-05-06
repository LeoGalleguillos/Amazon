<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use TypeError;

class SimilarProducts
{
    /**
     * Construct.
     */
    public function __construct(
        AmazonFactory\Product $productFactory,
        AmazonService\Api $apiService,
        AmazonService\Api\Product\Xml\DownloadToMySql $downloadToMySqlService,
        AmazonService\Api\SimilarProducts\Xml $apiSimilarProductsXmlService,
        AmazonService\Product $productService,
        AmazonTable\Product $productTable,
        AmazonTable\Product\Similar $productSimilarTable,
        AmazonTable\Product\SimilarRetrieved $productSimilarRetrievedTable
    ) {
        $this->productFactory               = $productFactory;
        $this->apiService                   = $apiService;
        $this->downloadToMySqlService       = $downloadToMySqlService;
        $this->apiSimilarProductsXmlService = $apiSimilarProductsXmlService;
        $this->productService               = $productService;
        $this->productTable                 = $productTable;
        $this->productSimilarTable          = $productSimilarTable;
        $this->productSimilarRetrievedTable = $productSimilarRetrievedTable;
    }

    public function getSimilarProducts(string $asin): array
    {
        $similarProducts = [];

        $asins = $this->productSimilarTable->getSimilarAsins($asin);
        if (!empty($asins)) {
            foreach ($asins as $asin) {
                try {
                    $similarProducts[] = $this->productFactory->buildFromAsin($asin);
                } catch (TypeError $typeError) {
                    // Do nothing.
                }
            }
            return $similarProducts;
        }

        if (!AmazonService\Api::GET_NEW_PRODUCTS
            || $this->apiService->wasAmazonApiCalledRecently()
            || $this->wereSimilarProductsRetrievedRecently($asin)
        ) {
            return [];
        }

        $xml = $this->apiSimilarProductsXmlService->getXml($asin);

        $this->apiService->insertOnDuplicateKeyUpdate(
            'last_call_microtime',
            microtime(true)
        );
        $this->productSimilarRetrievedTable->updateToNowWhereAsin($asin);

        if (!empty($xml->{'Items'}->{'Item'})) {
            foreach ($xml->{'Items'}->{'Item'} as $itemXml) {
                $similarAsin = (string) $itemXml->{'ASIN'};

                if (!$this->productTable->isProductInTable($similarAsin)) {
                    $this->downloadToMySqlService->downloadToMySql($itemXml);
                }

                $this->productSimilarTable->insertIgnore($asin, $similarAsin);

                $similarProducts[] = $this->productFactory->buildFromAsin($similarAsin);
            }
        }

        return $similarProducts;
    }

    /**
     * Were similar products retrieved recently.
     *
     * @param string $asin
     * @return bool
     */
    public function wereSimilarProductsRetrievedRecently(string $asin)
    {
        $similarRetrieved = $this->productSimilarRetrievedTable
                                 ->selectWhereAsin($asin);

        if (empty($similarRetrieved)) {
            return false;
        }

        return (strtotime($similarRetrieved) > strtotime('-7 days'));
    }
}
