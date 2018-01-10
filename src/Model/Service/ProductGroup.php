<?php
namespace LeoGalleguillos\Amazon\Model\Service;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class ProductGroup
{
    const MAX_NUMBER_OF_PAGES = 100;

    public function __construct(
        AmazonFactory\Product $amazonProductFactory,
        AmazonTable\ProductGroup $amazonProductGroupTable
    ) {
        $this->amazonProductFactory    = $amazonProductFactory;
        $this->amazonProductGroupTable = $amazonProductGroupTable;
    }

    public function getNumberOfPages(int $numberOfProducts) : int
    {
        $numberOfPages = ceil($numberOfProducts / 100);
        return ($numberOfPages > self::MAX_NUMBER_OF_PAGES)
             ? self::MAX_NUMBER_OF_PAGES
             : $numberOfPages;
    }

    public function getNumberOfProducts($productGroupName)
    {
        return $this->amazonProductGroupTable->selectCountWhereProductGroup($productGroupName);
    }

    /**
     * Get product entities.
     *
     * @param AmazonEntity\ProductGroup $productGroupEntity
     * @param int $page
     * @return AmazonEntityProduct[]
     */
    public function getProductEntities(
        AmazonEntity\ProductGroup $productGroupEntity,
        int $page
    ) : array {
        $asins = $this->amazonProductGroupTable->getAsins(
            $productGroupEntity,
            $page
        );

        $products = [];
        foreach ($asins as $asin) {
            $products[] = $this->amazonProductFactory->buildFromMySql($asin);
        }

        return $products;
    }

    public function insertIgnore($name)
    {
        if (empty($name)) {
            return;
        }
        $slug = preg_replace('/[^a-zA-Z0-9]/', '-', $name);
        $this->amazonProductGroupTable->insertIgnore($name, $slug);
    }
}
