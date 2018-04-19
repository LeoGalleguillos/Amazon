<?php
namespace LeoGalleguillos\Amazon\Model\Service\Search;

use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class ProductGroup
{
    const MAX_NUMBER_OF_PAGES = 100;

    /**
     * Construct.
     *
     * @param AmazonFactory\Product $productFactory,
     * @param AmazonFactory\ProductGroup $productGroupFactory,
     * @param AmazonTable\ProductGroup $productGroupTable,
     * @param AmazonTable\Search\ProductGroup $searchProductGroupTable
     */
    public function __construct(
        AmazonFactory\Product $productFactory,
        AmazonFactory\ProductGroup $productGroupFactory,
        AmazonTable\ProductGroup $productGroupTable,
        AmazonTable\Search\ProductGroup $searchProductGroupTable
    ) {
        $this->productFactory          = $productFactory;
        $this->productGroupFactory     = $productGroupFactory;
        $this->productGroupTable       = $productGroupTable;
        $this->searchProductGroupTable = $searchProductGroupTable;
    }

    /**
     * Get number of pages.
     *
     * @param int $numberOfResults
     * @return int
     */
    public function getNumberOfPages(int $numberOfResults) : int
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
        string $query,
        int $page
    ) : array {
        if (empty($query)) {
            return [];
        }

        $productIds = $this->searchProductGroupTable
            ->selectProductIdWhereMatchTitleAgainst(
                $productGroup->getSearchTable(),
                $query,
                ($page - 1) * 100,
                100
            );

        $products = [];
        foreach ($productIds as $productId) {
            $products[] = $this->productFactory->buildFromProductId($productId);
        }

        return $products;
    }

    /**
     * Get product group entites with search tables.
     *
     * @yield string
     */
    public function getProductGroupEntitiesWithSearchTables() : Generator
    {
        foreach ($this->productGroupTable->selectWhereSearchTableIsNotNull() as $array) {
            yield $this->productGroupFactory->buildFromArray($array);
        }
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
            $productEntity->productGroup->getSearchTable(),
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
