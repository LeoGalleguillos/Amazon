<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\Products;

use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class ProductGroupBindingBrand
{
    // const MAX_NUMBER_OF_PAGES = 100;

    public function __construct(
        AmazonFactory\Product $productFactory,
        AmazonTable\Product\ProductGroupBindingBrand $productGroupBindingBrandTable
    ) {
        $this->productFactory                = $productFactory;
        $this->productGroupBindingBrandTable = $productGroupBindingBrandTable;
    }

    /*
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
        return [];
        return $this->amazonBrandTable->selectCountWhereProductGroupBindingBrand(
            $productGroupName,
            $bindingName,
            $brandName
        );
    }
     */

    public function getProductEntities(
        AmazonEntity\ProductGroup $productGroupEntity,
        AmazonEntity\Binding $bindingEntity,
        AmazonEntity\Brand $brandEntity
    ): Generator {
        $result = $this->productGroupBindingBrandTable->selectWhereProductGroupBindingBrand(
            $productGroupEntity->getName(),
            $bindingEntity->getName(),
            $brandEntity->getName()
        );

        foreach ($result as $array) {
            yield $this->productFactory->buildFromArray($array);
        }
    }

    /*
    public function getProductEntitiesWithoutBinding($productGroupName, $brandName)
    {
        return [];
        $asins = $this->amazonBrandTable->selectAsinWhereProductGroupAndBrand(
            $productGroupName,
            $brandName
        );

        $products = [];
        foreach ($asins as $asin) {
            $products[] = $this->amazonProductFactory->buildFromMySql($asin);
        }

        return $products;
    }

    public function insertIgnore($name)
    {
        return;
        if (empty($name)) {
            return;
        }
        $slug = preg_replace('/[^a-zA-Z0-9]/', '-', $name);
        $this->amazonBrandTable->insertIgnore($name, $slug);
    }
     */
}
