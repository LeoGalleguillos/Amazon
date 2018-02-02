<?php
namespace LeoGalleguillos\Amazon\Model\Service;

use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Brand
{
    const MAX_NUMBER_OF_PAGES = 100;

    public function __construct(
        AmazonFactory\Product $amazonProductFactory,
        AmazonTable\Brand $amazonBrandTable
    ) {
        $this->amazonProductFactory = $amazonProductFactory;
        $this->amazonBrandTable     = $amazonBrandTable;
    }

    public function getNumberOfPages(int $numberOfProducts) : int
    {
        $numberOfPages = ceil($numberOfProducts / 100);
        return ($numberOfPages > self::MAX_NUMBER_OF_PAGES)
             ? self::MAX_NUMBER_OF_PAGES
             : $numberOfPages;
    }

    public function getNumberOfProducts(
        $productGroupName,
        $bindingName,
        $brandName
    ) {
        return $this->amazonBrandTable->selectCountWhereProductGroupBindingBrand(
            $productGroupName,
            $bindingName,
            $brandName
        );
    }

    public function getProductEntities(
        $productGroupName,
        $bindingName,
        $brandName,
        int $page
    ) {
        $asins = $this->amazonBrandTable->getAsins(
            $productGroupName,
            $bindingName,
            $brandName,
            $page
        );

        $products = [];
        foreach ($asins as $asin) {
            $products[] = $this->amazonProductFactory->createFromMySql($asin);
        }

        return $products;
    }

    public function insertIgnore($name)
    {
        if (empty($name)) {
            return;
        }
        $slug = preg_replace('/[^a-zA-Z0-9]/', '-', $name);
        $this->amazonBrandTable->insertIgnore($name, $slug);
    }
}
