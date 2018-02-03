<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class SimilarProducts
{
    /**
     * Construct.
     */
    public function __construct(
        AmazonFactory\Product $productFactory,
        AmazonService\Api $apiService,
        AmazonService\Api\SimilarProducts\Xml $apiSimilarProductsXmlService,
        AmazonService\Product $productService,
        AmazonService\Product\Download $productDownloadService,
        AmazonTable\Product\Similar $productSimilarTable,
        AmazonTable\Product\SimilarRetrieved $productSimilarRetrievedTable
    ) {
        $this->productFactory               = $productFactory;
        $this->apiService                   = $apiService;
        $this->apiSimilarProductsXmlService = $apiSimilarProductsXmlService;
        $this->productService               = $productService;
        $this->productDownloadService       = $productDownloadService;
        $this->productSimilarTable          = $productSimilarTable;
        $this->productSimilarRetrievedTable = $productSimilarRetrievedTable;
    }

    /**
     * Get similar products.
     *
     * @param string $asin
     * @return array
     */
    public function getSimilarProducts(string $asin) : array
    {
        $products = [];

        $asins = $this->productSimilarTable->getSimilarAsins($asin);
        if (!empty($asins)) {
            foreach ($asins as $asin) {
                $products[] = $this->productFactory->buildFromAsin($asin);
            }
            return $products;
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
                $product = $this->productFactory->buildFromXml($itemXml);

                if ($this->productService->isProductBanned($product->asin)) {
                    continue;
                }

                if (!$this->isProductInTable($product->asin)) {
                    $this->productDownloadService->downloadProduct($product);
                }

                $this->productSimilarTable->insertIfNotExists($asin, $product->asin);
                $products[] = $product;
            }
        }

        return $products;
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
