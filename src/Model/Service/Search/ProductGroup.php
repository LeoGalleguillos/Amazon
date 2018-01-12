<?php
namespace LeoGalleguillos\Amazon\Model\Service\Search;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class ProductGroup
{
    public function __construct(
        AmazonFactory\Product $productFactory,
        AmazonTable\Search\ProductGroup $searchProductGroupTable
    ) {
        $this->productFactory          = $productFactory;
        $this->searchProductGroupTable = $searchProductGroupTable;
    }

    public function getNumberOfPages($numberOfResults)
    {
        $numberOfPages = ceil($numberOfResults / 100);
        return ($numberOfPages > self::MAX_NUMBER_OF_PAGES)
             ? self::MAX_NUMBER_OF_PAGES
             : $numberOfPages;
    }

    public function getNumberOfResults($query) : int
    {
        $websiteEntity = $this->websiteService->getInstance();
        return $this->searchTable->selectCountWhereMatchTitleAgainst(
            $websiteEntity->searchTable,
            $query
        );
    }

    public function getSearchResults(
        AmazonEntity\ProductGroup $productGroup,
        string $query
    ) : array {
        if (empty($query)) {
            return [];
        }

        $productIds = $this->searchProductGroupTable
            ->selectProductIdWhereMatchTitleAgainst(
                $productGroup->searchTable,
                $query
            );

        $products = [];
        foreach ($productIds as $productId) {
            $products[] = $this->productFactory->buildFromProductId($productId);
        }

        return $products;
    }

    /**
     * Get similar products.
     *
     * @param AmazonEntity\Product $productEntity
     * @return AmazonEntity\Product[]
     */
    public function getSimilarProducts(
        AmazonEntity\Product $productEntity
    ) : array {
        $productIds = $this->searchProductGroupTable
            ->selectProductIdWhereMatchTitleAgainstAndProductIdDoesNotEqual(
            $productEntity->productGroup->searchTable,
            $productEntity->title,
            $productEntity->productId
        );

        $productEntities = [];
        foreach ($productIds as $productId) {
            $productEntities[] = $this->productFactory->buildFromProductId($productId);
        }
        return $productEntities;
    }
}
