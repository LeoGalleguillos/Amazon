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
        $query,
        $page
    ) {
        if (empty($query)) {
            return [];
        }

        $asins = $this->searchTable->selectAsinWhereMatchTitleAgainst(
            $websiteEntity->searchTable,
            $query,
            $page
        );

        $products = [];
        foreach ($asins as $asin) {
            $products[] = $this->productFactory->buildFromMysql($asin);
        }

        return $products;
    }

    public function getSimilarProducts(
        AmazonEntity\Product $productEntity,
        AmazonEntity\ProductGroup $productGroupEntity
    ) {
        $productIds = $this->searchTable->selectProductIdWhereMatchTitleAgainstAndProductIdDoesNotEqual(
            $productGroupEntity->searchTable,
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
